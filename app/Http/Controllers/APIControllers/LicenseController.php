<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenseResource;
use App\Http\Requests\LicenseRequest;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LicenseResource::collection(License::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LicenseRequest $request)
    {
        $hash_key = md5($request->ea_id."_".$request->account_number);
        
        $before = License::where(['ea_id'=> $request->ea_id, 'user_id'=> $request->user_id])->count();
        if(!$request->is_admin && $before>=3) {
            return response([
                'success' => false, 
                'message' => "License count can not excceed 3.", 
                'status_code' => 400
              ]);
        }

        $license = License::create([
            'ea_id' => $request->ea_id,
            'account_number' => $request->account_number,
            'user_id' => $request->user_id,
            'hash_key' => $hash_key,
            'allow_flag' => $request->allow_flag,
        ]);

        return new LicenseResource($license);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\License  $license
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $license = License::findOrFail($id);
        return new LicenseResource($license);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\License  $license
     * @return \Illuminate\Http\Response
     */
    public function edit(License $license)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\License  $license
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hash_key = md5($request->ea_id."_".$request->account_number);
        $license = License::findOrFail($id);
        $license->ea_id = $request->ea_id;
        $license->account_number = $request->account_number;
        $license->user_id = $request->user_id;
        $license->hash_key = $hash_key;
        $license->allow_flag = $request->allow_flag;
        $license->save();

        return $license;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\License  $license
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $license->delete();
        return response([
            'success' => "successfully deleted"
        ]);
    }

    public function getByEaId($ea_id, $user_id) {
        $licenses = License::where(['ea_id'=> $ea_id, 'user_id' => $user_id])
            ->get();
        return LicenseResource::collection($licenses);
    }
}
