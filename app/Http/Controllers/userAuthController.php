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
                'exp'  => time()+60*60*24
            ];


            //Generate JWT Token

            $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');


            return response()->json([
                'success' => true,
                'message' => 'login successfull',
                'token'  => $token
            ]);

    }
}
