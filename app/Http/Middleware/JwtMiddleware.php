<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

             $token = $request-> bearerToken();

             if(!$token) {

                return response()->json(['error' => 'Token not provided'],401);
             }

             $decoded = JWT::decode($token, new key (env('JWT_SECRET'), 'HS256'));

            //  $request->auth = $decoded;

            $user = User::find($decoded->sub);


             if (!$user) {
            return response()->json(['error' => 'User not found'], 401);
        }


        auth () -> setUser($user);


        $request->auth_user = $decoded;

        



        return $next($request);
    }
}
