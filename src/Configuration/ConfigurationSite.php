<?php

namespace App\file\Configuration;


class ConfigurationSite
{

    static private int $dureeExpiration = 30 * 60;

    public static function getDureeExpiration(): int
    {
        return ConfigurationSite::$dureeExpiration;
    }

    public static function getURLAbsolue(): string
    {
        return "http://localhost/fileAttente/web/controleurFrontal.php";
    }

    public static function getDebug(): bool{
        return false;
    }

}