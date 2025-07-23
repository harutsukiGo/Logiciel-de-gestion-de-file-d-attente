<?php
namespace App\file\Modele\HTTP;
class Cookie
{
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void
    {
        if ($dureeExpiration == null){
            setcookie($cle, serialize($valeur), 0);
        }else{
        setcookie($cle, serialize($valeur), $dureeExpiration);
        }
    }

    public static function lire(string $cle): mixed
    {
        return unserialize($_COOKIE[$cle]);
    }

    public static function contient($cle) : bool
    {
        return array_key_exists($cle, $_COOKIE);
    }

    public static function supprimer($cle) : void
    {
        setcookie($cle, "", 1);
    }
}