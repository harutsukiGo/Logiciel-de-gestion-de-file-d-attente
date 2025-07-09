<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$chargeurDeClasse = new \App\file\Lib\Psr4AutoloaderClass();
$chargeurDeClasse->register();
$chargeurDeClasse->addNamespace('App\file', __DIR__ . '/../src');

use App\file\Modele\Repository\ConnexionBaseDeDonnees;
use App\file\Controleur\ControleurAccueil;

//$r = ConnexionBaseDeDonnees::getPdo()->query("Select nomService FROM services WHERE idService = 1");
//$result= $r->fetch();
// echo "Nom du service : " . $result['nomService'];
 ControleurAccueil::afficherAccueil();
?>