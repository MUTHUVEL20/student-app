<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class userAuthController extends Controller
{
    

    public function userLogin (Request $request) {


           $validated = $request->validate(
            [
                'email' => 'required|email|max:191',
                'password' => 'required|max:191'
            ]);


            $user = User::where('email',$request->email)->first();


            if(!$user || ($request->password !== $user->password)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User'
                ]);
            }


            //Generate new token  -> generate API Token when login

            // $token = Str::random(60);


            // $user->update([
            //     'api_token'=> $token
            // ]);


            //Generate JWT Token -> Instead of API Token using JWT


            $payload =    [

                'iss' => "laravel-jwt",
                'sub' => $user->id,
                'email' => $user->email,
                'role'  => $user->role,
                'iat'   => time(),
                'exp'  => time()+ 60 * 2 //Access Token valid 15 minutes
            ];


            //Generate JWT Access Token

            $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

            //Generate JWT Refresh Token



            // $refreshPayload = [
            //     'sub' => $user->id,
            //     'exp' => time()+ (60 * 60 * 24 * 7) // Refresh token valid 7 days
            // ];


               $refreshPayload = [
                'sub' => $user->id,
                'exp' => time()+ (60 * 5) // Refresh token valid 7 days
            ];

            $refreshToken = JWT::encode($refreshPayload, env('JWT_SECRET'), 'HS256');

            $user->update([
                'refresh_token' => $refreshToken
            ]);


            return response()->json([
                'success' => true,
                'message' => 'login successfull',
                'access token'  => $token,
                'refresh token'  =>  $refreshToken
            ]);

    }




    public function refreshToken (Request $request) {


        $refreshToken = $request->refresh_token;

        if(!$refreshToken) {

            return response()->json(['error' => 'Refresh Token Required'],400);
        }


        $decoded = JWT::decode($refreshToken, new key (env('JWT_SECRET'), 'HS256'));


        $user = User::find($decoded->sub);


        if(!$user || $user->refresh_token !== $refreshToken) {


            return response()->json(['error' => 'Invalid Refresh Token'],401);
        }



        $payload = [
            'sub' => $user->id,
            'email'=>$user->email,
            'role' => $user->role,
            'exp' => time() + 60 * 15
        ];


        $newAccessToken = JWT::encode($payload, env ('JWT_SECRET'), 'HS256');


        return response()->json([
            'success'=> true,
            'newAccessToken' => $newAccessToken
        ]);



    }
}
