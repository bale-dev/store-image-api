<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Create user
    public function userRegister(Request $request) {

        try {

            // Initiate filed validation 
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8'
            ]);

            // Response if field validation fails
            if( $validateUser->fails() ){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or password validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }   

            // Create user 
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Response when user was successfully created
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Sign In user
    public function userLogin( Request $request ){

        try {
            // Initiate filed validation 
            $validateUserFields = Validator::make($request->all(),
            [
                'email' => 'required|email|max:255',   
                'password' => 'required|min:8'
            ]);

            // Response if field validation fails
            if($validateUserFields->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'User authentication failed',
                    'errors' => $validateUserFields->errors()
                ], 401);
            }

            // Response if email and password don't match in DB
            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => "Email or password don't match.",
                ], 401);
            }

            
            // Get user data from DB where emails match
            $user = User::where('email', $request->email)->first();

            // Response when user logged and create token
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
            

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);

        }


    }
}
