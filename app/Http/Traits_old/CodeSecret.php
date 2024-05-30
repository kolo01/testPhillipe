<?php
namespace App\Http\Traits;


/**
 * Genrateur de code secret de (7) chiffres et lettres
 */
trait CodeSecret
{
    protected function generateCode(){

        $numero = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ@1234567890';

        $code = '';

        for ($i = 0;$i < 7;$i++)
        {
            $code .= substr($numero, rand() % (strlen($numero)) , 1);
        }
        return $code;
    }

}







?>