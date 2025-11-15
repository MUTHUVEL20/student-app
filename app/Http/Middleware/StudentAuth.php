<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use  App\Models\User;

class StudentAuth
{
    
    public function handle(Request $request, Closure $next)
    {


        $token = $request-> header('X-API-TOKEN');

        //  $validToken = env ('API_TOKEN');

        $user = User::where('api_token', $token)->first();

        if(!$user) {

            return redirect()->route('login.page')->with('error','please login first');
        }


        auth()->setUser($user);


        return $next($request);
    }
}
