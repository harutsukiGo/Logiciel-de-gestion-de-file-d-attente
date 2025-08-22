<?php
namespace App\file\Modele\HTTP;

use App\file\Configuration\ConfigurationSite;
use Exception;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
                throw new Exception("La session n'a pas réussi à démarrer.");
            }
      }

    public static function getInstance(): Session
    {
        Session::verifierDerniereActivite();
        if (is_null(Session::$instance))
        Session::$instance = new Session();
        return Session::$instance;

    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, mixed $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed
    {
        if (!isset($_SESSION[$nom])){
            return null;
        }
        return $_SESSION[$nom];
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
//        $this->detruire();
    }

    public static function verifierDerniereActivite()
    {
        if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > ConfigurationSite::getDureeExpiration())){
            session_unset();
        }

        $_SESSION['derniereActivite'] = time();
    }

    public function detruire(): void
    {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
// Il faudra reconstruire la session au prochain appel de getInstance()
        Session::$instance = null;
    }

    public function heureDeConnexion(): string
    {
        date_default_timezone_set('Europe/Paris');
        if (!isset($_SESSION['heureDeConnexion'])) {
            $_SESSION['heureDeConnexion'] = time();
        }
        return date('H:i:s', $_SESSION['heureDeConnexion']);
    }

    public function tempsMoyen():string
    {
        date_default_timezone_set('Europe/Paris');
        if (!isset($_SESSION['heureDeConnexion'])) {
            return "0 min";
        }
        $duree = time() - $_SESSION['heureDeConnexion'];
        $minutes = floor($duree / 60);
        return "$minutes min";
    }
}

