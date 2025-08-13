<?php

use App\file\Modele\DataObject\Agents;
use App\file\Modele\Repository\ServiceRepository;

/** @var Agents $agent */ ?>
<section class='sectionDetailAgent'>
    <h2> Espace Agent</h2>
    <p class="descriptionAgent"> Espace regroupant les données de l'agent connecté</p>


    <div class='divDetailAgent'>
        <div class="divStautAgentDetail">

            <p class="nomAgent">Agent : <?php echo $agent->getNomAgent() ?> </p>

            <?php
            $statut = $agent->getStatut();
            if ($statut) {
                echo "<svg class='statutAgent' width='20' height='20' style='animation: blink 1.5s infinite alternate;'><circle cx='10' cy='10' r='8' fill='rgb(34 197 94)'/></svg>";
            } else {
                echo "<svg class='statutAgent' width='20' height='20' style='animation: blink 1.5s infinite alternate;'><circle cx='10' cy='10' r='8' fill='red'/></svg>";
            }
            ?>
        </div>
        <div class="divParametresAgentDetail">
            <div class="divEnfantAgentDetail"><?php echo "Adresse e-mail : " . $agent->getMailAgent() ?></div>
            <div class="divEnfantAgentDetail"><?php $service = (new ServiceRepository())->recupererParClePrimaire($agent->getIdService()->getIdService()); ?>
                <?php echo "Service : " . $service->getNomService(); ?></div>
            <div class="divEnfantAgentDetail"><?php echo "Rôle : " . $agent->getRole() ?></div>
            <div class="divEnfantAgentDetail"><?php echo $agent->getIdGuichet()->getNomGuichet() ?></div>
        </div>
        <div class="divButtonDeconnexion">
            <button id='btnDeconnexion'
                    onclick="window.location.href='controleurFrontal.php?controleur=agent&action=deconnecter'">
                Déconnexion
            </button>
        </div>
    </div>
</section>
