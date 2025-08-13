<?php

namespace App\file\Lib;

use App\file\Modele\HTTP\Session;

class ConnexionUtilisateur
{
    private static string $cleConnexion = "_agentConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        Session::getInstance()->enregistrer(ConnexionUtilisateur::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(ConnexionUtilisateur::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(ConnexionUtilisateur::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        if (ConnexionUtilisateur::estConnecte()) {
            return Session::getInstance()->lire(ConnexionUtilisateur::$cleConnexion);
        } else {
            return null;
        }
    }

    public static function retourneHeureConnexionAgent(): string
    {
        return Session::getInstance()->heureDeConnexion();
    }

    public static function tempsMoyen(): string
    {
        return Session::getInstance()->tempsMoyen();
    }
}