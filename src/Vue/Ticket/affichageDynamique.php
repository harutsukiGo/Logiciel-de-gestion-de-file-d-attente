<section class="headerDynamique">

        <h2 class="nomEntreprise"> Bienvenue chez <?php
            use App\file\Modele\Repository\ParametresRepository;
            echo (new ParametresRepository())->getValeur("nom_organisation")->getValeur(); ?></h2>

     <p id="horloge"></p>
     <?php
    /** @var Ticket[] $premierTicket * */

    use App\file\Modele\DataObject\enumPublicite;

    ?>
    <div class="divAppelEnCours">
        <h2> Appel en cours</h2>
        <div class="ticketCourant">
            <h1 class="h1TicketCourant"></h1>
            <?php if (count($premierTicket) == 0): ?>
                <p id='numTicketCourant'>Aucun tickets </p>
                <p id="nomServiceCourant">Aucun service </p>
                <p id="numeroGuichet">Aucun guichet </p>
            <?php else: ?>
                <?php foreach ($premierTicket as $ticket): ?>
                    <input type="hidden" id="idTicket" value="<?php echo $ticket['idTicket'] ?>">
                    <?php echo " <p id='numTicketCourant'> N° " . $ticket["num_ticket"] . "</p>" ?>
                    <p id="nomServiceCourant">  <?php echo $ticket["nomService"] ?></p>
                    <p id="numeroGuichet"> <?php echo $ticket["nom_guichet"] ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</section>
<div class="divDynamique">

    <div class="colonneGauche">

        <?php
        /** @var Publicite[] $publicites * */
        ?>
        <div class="divPublicite">
            <?php foreach ($publicites as $key => $publicite): ?>
                <?php if ($publicite->getEstActif()): ?>
                    <?php if ($publicite->getType() === enumPublicite::VIDEO): ?>
                        <iframe class="imgPub" src="<?php
                        $videoUrl = $publicite->getFichier();
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                        $videoId = isset($matches[1]) ? $matches[1] : '';
                        echo "https://www.youtube.com/embed/" . $videoId . "?autoplay=1&mute=1&loop=1&playlist=" . $videoId;
                        ?>" title="YouTube video player" allow="autoplay" frameborder="0" allowfullscreen></iframe>
                    <?php else: ?>
                        <img class="imgPub <?= $key === 0 ? 'active' : 'hidden' ?>"
                             src="<?= $publicite->getFichier() ?>"
                             alt="Publicité"
                             data-index="<?= $key ?>">
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
     </div>


    <div class="colonneMilieu">
        <div class="fileAttente">
            <h2> File d'attente</h2>
            <?php
            /** @var Service[] $service */

            use App\file\Modele\DataObject\Publicite;
            use App\file\Modele\DataObject\Service;
            use App\file\Modele\DataObject\Ticket;
            use App\file\Modele\Repository\ServiceRepository;

            ?>
            <?php foreach ($service as $s): ?>
                <div class="service-div">
                    <div class="nomServiceDiv">
                        <?php $nomService = htmlspecialchars($s["nomService"]);
                        echo "<h3 class='h3Service'>" . $nomService . "</h3>"; ?>
                    </div>
                    <div class="nbPersonneAttenteDiv">
                        <?php $nbPersonne = (new ServiceRepository())->getNbPersonneAttente($s["idService"]); ?>
                        <?php echo "<p class='nbPersonneAttenteFile'> $nbPersonne</p>" ?>
                        <p class="texteEnAttente"> en attente</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


