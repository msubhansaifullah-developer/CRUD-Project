<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
          //Sign Up function
    public function signup(Request $request){
        $validateUser=Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'validation Error',
                'errors'=>$validateUser->errors()->all()
            ],401);
        }$user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);

         return response()->json([
                'status'=>true,
                'message'=>'user created successfully',
                'user'=>$user,
            ],200);
    }
             //Login function
    public function login(Request $request){
        $validateUser=Validator::make($request->all(),
        [
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Authentication fails',
                'errors'=>$validateUser->errors()->all()
            ],404);
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                   $authuser=Auth::user();
                    return response()->json([
                    'status'=>true,
                    'message'=>'user Logged in successfully',
                    'token'=>$authuser->createToken("API Token")->plainTextToken,
                    'token_type'=>'bearer',
                        ],200);
                    }
                    else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Email and password do not match',
                     ],401);
                    }
    }

    public function logout(Request $request){
        $user=$request->user();
        $user->tokens()->delete();
        return response()->json([
        'status'=>true,
        'message'=>'You logged out successfully'
        ],200);
    }
}
