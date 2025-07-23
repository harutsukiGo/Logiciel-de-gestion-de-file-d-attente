<?php

use App\file\Lib\ConnexionUtilisateur;
use App\file\Modele\DataObject\Agents;
/** @var Agents $agent */

echo "<h1>Agent : " . $agent->getNomAgent() . "</h1>";
echo "<p>Statut : " . ($agent->getStatut() ? "Actif" : "Inactif") . "</p>";
echo "<p>Rôle : " . $agent->getRole() . "</p>";
echo "<p> " . $agent->getIdGuichet()->getNomGuichet() . "</p>";
echo "<p>Adresse e-mail : " . $agent->getMailAgent() . "</p>";
?>
<button ><a href="controleurFrontal.php?controleur=agent&action=deconnecter"> Déconnexion </button>
