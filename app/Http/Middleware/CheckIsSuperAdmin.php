<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsSuperAdmin
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
         // Vérifier si l'utilisateur est authentifié et n'est pas en mode test
    if (auth()->check() && (auth()->user()->isInTest()) != 1 && (auth()->user()->role) == "superAdmin") {
      return $next($request);
    }

    // Rediriger ou renvoyer une réponse en cas de non-accès
    return redirect('/');
    }
}
