<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$chargeurDeClasse = new \App\file\Lib\Psr4AutoloaderClass();
$chargeurDeClasse->register();
$chargeurDeClasse->addNamespace('App\file', __DIR__ . '/../src');

$action = $_GET['action'] ?? 'afficherAccueil';
$controleurNom = ucfirst($_GET['controleur'] ?? 'accueil');
$nomClasseControleur = "App\\file\\Controleur\\Controleur" . $controleurNom;

if (!class_exists($nomClasseControleur)) {
    throw new RuntimeException("Controleur inexistant");
}

$controleur = new $nomClasseControleur();
if (!method_exists($controleur, $action)) {
    throw new RuntimeException("Action inexistante");
}

$controleur->$action();
?>