<?php

namespace App\Auth;

use Illuminate\Auth\SessionGuard;

class CustomSessionGuard extends SessionGuard
{
    /**
     * Override la méthode validateCredentials pour ignorer la vérification du mot de passe.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    protected function validateCredentials($user, array $credentials)
    {
        return true;
    }
}
