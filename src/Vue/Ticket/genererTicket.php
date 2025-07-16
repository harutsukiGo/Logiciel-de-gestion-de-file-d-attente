<?php
/** @var Service $idService */
/** @var Ticket $ticket */
use App\file\Modele\DataObject\Service;
use App\file\Modele\DataObject\Ticket;
use App\file\Modele\Repository\ServiceRepository;

?>

<div class="divRetourAccueil">
<button id="retourAccueil-btn" onclick="window.location.href='/fileAttente/web/controleurFrontal.php'">
    Retour à l'accueil
</button>
</div>
<section class="sectionDetailService">

    <div class="descriptionService">
        <h1 class="titreService">Ticket généré </h1>
        <p class="descriptionServiceBorne">Votre ticket a été créé avec succès</p>
        <p class="titreService"> <?php echo htmlspecialchars((new ServiceRepository())->getNomService($idService)); ?></p>
        <p class="titreServiceTicket"> <?php echo $ticket->getNumTicket(); ?></p>
        <p><?php echo date('H:i'); ?></p>
        <div class="service-informations">
                <p> Gardez ce ticket avec vous. Vous serez appelé prochainement. </p>
            </div>
        </div>





</section>