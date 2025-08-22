<?php

namespace App\file\Lib;

use App\file\Modele\HTTP\Session;
use App\file\Modele\Repository\AgentRepository;

class ConnexionAgent
{
    private static string $cleConnexion = "_agentConnecte";

    public static function connecter(string $loginAgent): void
    {
        Session::getInstance()->enregistrer(ConnexionAgent::$cleConnexion, $loginAgent);
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(ConnexionAgent::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(ConnexionAgent::$cleConnexion);
    }

    public static function getIdAgentConnecte(): ?string
    {
        if (ConnexionAgent::estConnecte()) {
            return Session::getInstance()->lire(ConnexionAgent::$cleConnexion);
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
        $agent = (new AgentRepository())->recupererParClePrimaire(ConnexionAgent::getIdAgentConnecte());
        return $agent->getRole() == 'administrateur';
    }
}