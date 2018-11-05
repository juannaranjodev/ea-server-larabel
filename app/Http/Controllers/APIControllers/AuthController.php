<?php

namespace App\Http\Controllers\APIControllers;

use App\User;
use App\PasswordResets;
use App\SendMailable;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RegistersUsers;
use Storage;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     use RegistersUsers;
        
    public function register(Guard $auth, Request $request) {
        $fields = ['email', 'password', 'name','verification'];
        // grab credentials from the request
        $credentials = $request->only($fields);

        // $clientVerification = $credentials['verification'];//$request->verification;

        // $serverVerification = Storage::get('verification');

        // Storage::put('verification', '');

        // if ($serverVerification != $clientVerification) {
        //     return response([
        //         'success' => false, 
        //         'message' => "Verification Code Error!", 
        //         'status_code' => 400
        //     ]);
        // }

        $validator = Validator::make(
            $credentials,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
            ]
            );
        if ($validator->fails())
        {
            // ruby test
            //return response($validator->messages());
            return response([
                'success' => false, 
                'message' => "Validation Failed!", 
                'status_code' => 400
            ]);
        }
        
        $result = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
        
        $result['token'] = $this->tokenFromUser($result['id']);        

        return response($result->only(['email', 'token']));
    }
    
    
    protected function login(Request $request) {
        
        auth()->shouldUse('api');
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $result['token'] = auth()->issue();
            $result['email'] = $credentials['email'];
            $user = User::where('email', '=' , $credentials['email'])->first();
            // ruby test <
            if(!$user->is_allowed) {
                return response([
                    'success' => false, 
                    'message' => "The user is not allowed yet!", 
                    'status_code' => 400
                ]);
            }
            // ruby test >
            $result['role'] = $user->role;
            $result['id'] = $user->id;
           return response($result);
        }
        //ruby test:
        //return response(['Invalid Credentials']);
        return response([
            'success' => false, 
            'message' => 'Invalid credentials!', 
            'status_code' => 400
        ]);
    }
    
    public function tokenFromUser($id)
    {
        // generating a token from a given user.
        $user = User::find($id);
    
        auth()->shouldUse('api');
        // logs in the user
        auth()->login($user);
    
        // get and return a new token
        $token = auth()->issue();
    
        return $token;
    }

    public function passwordResetEmail(Request $request) {
        $fields = ['email', 'url'];
        // grab credentials from the request
        $credentials = $request->only($fields);
        foreach($fields as $field) {
            $credentials[$field] = trim($credentials[$field]);
        }

        $validator = Validator::make(
            $credentials,
            [
                'email' => 'required|email|max:255',
                'url' => 'required'
            ]
            );
        if ($validator->fails())
        {
            return response([
                'success' => false, 
                'message' => $validator->messages(), 
                'status_code' => 400 
            ]);
        }

        $email = $credentials['email'];

        $user = User::where('email', '=' , $email)->first();
        if(!$user) {
            return response([
                'success' => false, 
                'message' => 'We can not find email you provided in our database! You can register a new account with this email.', 
                'status_code' => 404 
            ]);
        }
        
        // delete existings resets if exists
        PasswordResets::where('email', $email)->delete();
        
        $url = $credentials['url'];
        $token = md5($user->password);
        $result = PasswordResets::create([
            'email' => $email,
            'token' => $token
        ]);
        
        $url = $url."/".base64_encode($email)."_FAI35_".$token;

        if($result) {

            Mail::to($email)->queue(new SendMailable($url, $token, $email));
            return response([
                'success' => true, 
                'message' => 'The mail has been sent successfully!', 
                'status_code' => 201
            ]);
        }
        return response([
            'success' => false, 
            'message' => $error, 
            'status_code' => 500 
        ]);
    }
    public function resetPassword(Request $request)
    {
      $rules = [
        'email' => 'required|max:255',
      ];
      $validator = \Validator::make($request->only('email'), $rules);
      if ($validator->fails()) {
        return response([
            'success' => false, 
            'message' => "Invalid Email!", 
            'status_code' => 400
        ]);
      }
      $email = $request->input('email');
      $user = User::where('email', $email)->first();
      if (!isset($user)) {
        return response([
            'success' => false, 
            'message' => "Email is not exist.", 
            'status_code' => 400
        ]);
      }
      $md5_password = $request->input('md_password');
      if (md5($user->password) == $md5_password) {
        $password = $request->input('password');
        $user->password = bcrypt($password);
        $user->save();
        return response([
            'success' => true, 
            'message' => "Password reset succeed.", 
            'status_code' => 200
          ]);
      }
      return response([
        'success' => false, 
        'message' => "Password reset failed.", 
        'status_code' => 400
      ]);
    }
    
 }
