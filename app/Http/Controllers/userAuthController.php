<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

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


            if(!$user || !Hash::check($request->password, $user->password)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User'
                ]);
            }


            //Generate new token 

            $token = Str::random(60);


            $user->update([
                'api_token'=> $token
            ]);


            return response()->json([
                'success' => true,
                'message' => 'login successfull',
                'token'  => $token
            ]);

    }
}
