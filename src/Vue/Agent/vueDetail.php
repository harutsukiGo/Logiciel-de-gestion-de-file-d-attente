<?php

use App\file\Modele\DataObject\Agents;
/** @var Agents $agent */
echo "<section class='sectionDetailAgent'>".
"<h2> Espace Agent</h2>".
"<p> Bienvenue Agent " . $agent->getNomAgent() ."</p>";

echo "<div class='divDetailAgent'>".
     "<p>Statut : " . ($agent->getStatut() ? "Actif" : "Inactif") . "</p>" .
    "<p>Rôle : " . $agent->getRole() . "</p>" .
    "<p> S'occupe du " . $agent->getIdGuichet()->getNomGuichet() . "</p>" .
    "<p>Adresse e-mail : " . $agent->getMailAgent() . "</p>" .
    "<button id='btnDeconnexion' onclick=\"window.location.href='controleurFrontal.php?controleur=agent&action=deconnecter'\"> Déconnexion</button>" .
    "</div>";
echo "</section>";