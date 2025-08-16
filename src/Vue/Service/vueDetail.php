<?php
/** @var Service $service */

use App\file\Modele\Repository\ServiceRepository;

$nbPersonneAttente = (new ServiceRepository())->getNbPersonneAttente($service);

?>

<section class="intro">
<h1> <?php echo htmlspecialchars((new ServiceRepository())->recupererParClePrimaire($service)->getNomService()); ?></h1>
<p>Sélectionnez le service souhaité pour obtenir votre ticket</p>

</section>
<section class="sectionDetailService">
    <div class="descriptionService">
        <h1 class="titreService">Confirmation</h1>
        <p class="descriptionServiceBorne">Vous êtes sur le point de prendre un ticket pour le service suivant </p>
        <p class="titreService"> <?php echo htmlspecialchars((new ServiceRepository())->recupererParClePrimaire($service)->getNomService()); ?></p>
        <div class="service-informations">
            <div class="div-tempsAttente">
                <?php echo "<p class='nbPersonneAttente'>   $nbPersonneAttente" ?>
                <p> Personnes en attente </p>
            </div>
        </div>

                <button id="confirmation-btn" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=genererTicket&controleur=ticket&idService=<?php echo htmlspecialchars($service); ?>'">
                    Confirmer et prendre un ticket
                </button>
                <button id="annuler-btn" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherService&controleur=service'">
                    Annuler
                </button>


</section>