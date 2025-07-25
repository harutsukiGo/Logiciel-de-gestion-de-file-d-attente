<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
use App\file\Lib\PreferenceControleur;
use App\file\Modele\HTTP\Cookie;


$chargeurDeClasse = new App\file\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
$chargeurDeClasse->addNamespace('App\file', __DIR__ . '/../src');

try {
    if (!isset($_REQUEST['controleur'])) {
        $nomControleur = PreferenceControleur::existe()
            ? "App\\file\\Controleur\\Controleur" . ucfirst(Cookie::lire('preferenceControleur')) : "App\\file\\Controleur\\ControleurAccueil";
    } else {
        $nomControleur = "App\\file\\Controleur\\Controleur" . ucfirst($_REQUEST['controleur']);
    }

    if (!class_exists($nomControleur)) {
        throw new Exception("La classe contrôleur n'existe pas : " . $nomControleur);
    }

    $controleur = new $nomControleur();
    $action = $_REQUEST['action'] ?? 'afficherAccueil';
    if (!method_exists($controleur, $action)) {
        throw new Exception("L'action spécifiée n'existe pas : " . $action);
    }

    $controleur->$action();
} catch (Exception $e) {
    return;
}
