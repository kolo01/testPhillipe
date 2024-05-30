<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et n'est pas en mode test
        if (auth()->check() && (auth()->user()->isInTest() != 1)) {
            return $next($request);
        }

        // Rediriger ou renvoyer une réponse en cas de non-accès
        return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
    }
}
