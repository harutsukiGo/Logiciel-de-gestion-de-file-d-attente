<?php

namespace App\file\Configuration;

class ConfigurationBaseDeDonnees
{


    static private array $configurationBaseDeDonnees = array(
        'nomHote' => 'db',
        'nomBaseDeDonnees' => 'stageDB',
        'port' => '3306',
        'login' => 'manu',
    );


    static public function getLogin(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['login'];
    }


    static public function getNomHote(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomHote'];
    }


    static public function getPort(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['port'];
    }

    static public function getNomBaseDeDonnees(): string
    {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomBaseDeDonnees'];
    }

    static public function getPassword(): string
    {
        $env = parse_ini_file(__DIR__ . '/.env');
        return $env['DB_PASS'];
    }

}

