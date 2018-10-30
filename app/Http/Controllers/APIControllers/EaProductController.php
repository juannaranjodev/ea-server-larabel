<?php

namespace App\Http\Controllers\APIControllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EaProductResource;
use App\Http\Requests\EaProductRequest;
use App\Models\EaProduct;
use App\User;
class EaProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return User::all();
        return EaProductResource::collection(EaProduct::all());

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
    public function store(EaProductRequest $request)
    {
        $ea_product = EaProduct::create([
            'ea_id' => $request->ea_id,
            'ea_name' => $request->ea_name,
            'user_id' => $request->user_id,
            'parameter' => $request->parameter,
        ]);

        return new EaProductResource($ea_product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EaProduct  $eaProduct
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ea_product = EaProduct::findOrFail($id);
        return new EaProductResource($ea_product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EaProduct  $eaProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(EaProduct $eaProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EaProduct  $eaProduct
     * @return \Illuminate\Http\Response
     */
    public function update(EaProductRequest $request, $id)
    {
        $ea_product = EaProduct::findOrFail($id);
        $ea_product->ea_name = $request->ea_name;
        $ea_product->ea_id = $request->ea_id;
        $ea_product->user_id = $request->user_id;
        $ea_product->parameter = $request->parameter;
        $ea_product->save();

        return $ea_product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EaProduct  $eaProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ea_product = EaProduct::findOrFail($id);
        $ea_product->delete();
    }
}
