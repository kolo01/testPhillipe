<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\DB;

class apiToken
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('USER-ID');
        if(!$token){
            return response()->json(['message' => 'id du user est invalide'], 403);
        }
         $user = DB::table('users')->where('id_', $token)->first();

        if(!$user){
            return response()->json(['message' => 'connexion invalide'], 403);
        }
       return response()->json(['user' => $user], 200);

       Auth::login($user);

        return $next($request);
    }
}

   //->middleware('App\Http\Middleware\ApiToken');

