<?php

namespace App\file\Lib;

use App\file\Modele\HTTP\Session;
use App\file\Modele\Repository\AgentRepository;

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

    public static function getIdAgentConnecte(): ?string
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

    public static function estAdministrateur(): bool
    {
        $agent = (new AgentRepository())->recupererParClePrimaire(ConnexionUtilisateur::getIdAgentConnecte());
        return $agent->getRole() == 'administrateur';
    }
}