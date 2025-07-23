<?php

namespace App\file\Lib;

use App\file\Modele\HTTP\Session;

class ConnexionUtilisateur
{
// L'utilisateur connecté sera enregistré en session associé à la clé suivante
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

    public static function estUtilisateur($login): bool
    {
        if (ConnexionUtilisateur::getLoginUtilisateurConnecte() == $login) {
            return true;
        }
        return false;
    }


//    public static function estAdministrateur() : bool
//    {
//        $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
//        if (is_null($login)){
//            return false;
//        }
//        $r = ConnexionBaseDeDonnees::getPdo()->prepare("Select estAdmin FROM utilisateur WHERE login = :login");
//        $r->execute(array("login" => $login));
//        $admin = $r->fetch();
//
//        if($admin['estAdmin'] == 1){
//            return true;
//        }
//        return false;
//    }
}