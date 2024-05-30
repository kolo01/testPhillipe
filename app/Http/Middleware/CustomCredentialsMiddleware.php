<?php

namespace App\Http\Middleware;

use Closure;

class CustomCredentialsMiddleware
{
    public function handle($request, Closure $next)
    {
        $credentials = $request->only(['email']);

        // Vérifiez si la clé 'password' est manquante dans les credentials
        if (!isset($credentials['password'])) {
            $credentials['password'] = ''; // Ajoutez une valeur par défaut pour 'password'
        }

        $request->merge(['credentials' => $credentials]);

        return $next($request);
    }
}
