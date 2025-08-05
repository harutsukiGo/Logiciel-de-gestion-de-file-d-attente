<?php

namespace App\file\Lib;

class MotDePasse
{
    private static string $poivre = "teLgc+kpe/ahdWPCCg4fp6";

    public static function hacher(string $motDePasse): string
    {
        $mdpPoivre = hash_hmac("sha256", $motDePasse, self::$poivre);
        return password_hash($mdpPoivre, PASSWORD_DEFAULT);
    }

    public static function verifier(string $motDePasse,string $hash): bool
    {
        $mdpPoivre = hash_hmac("sha256", $motDePasse, self::$poivre);
        return password_verify($mdpPoivre, $hash);
    }


}
