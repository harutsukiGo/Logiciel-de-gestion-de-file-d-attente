<section class="headerDynamique">
    <button id="btnRetour" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-arrow-left w-5 h-5" style="vertical-align: middle; margin-right: 5px;">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        <span>Retour</span>
    </button>

    <h1 class="h1SalleAttente"> Écran de salle d'attente </h1>
    <button id="btnSimuler" onclick="simuler()"> Simuler l'appel</button>
</section>
<?php
/** @var Ticket[] $premierTicket * */

use App\file\Modele\DataObject\enumPublicite;

?>
<div class="divDynamique">

    <div class="colonneGauche">

        <div class="divAppelEnCours">
            <h2> Appel en cours</h2>
            <div class="ticketCourant">
                <h1 class="h1TicketCourant"></h1>
                <?php if (count($premierTicket) == 0): ?>
                     <p id='numTicketCourant'>Aucun tickets à traiter actuellement</p>
                    <p id="nomServiceCourant">Aucun service  </p>
                    <p id="numeroGuichet">Aucun guichet  </p>
                <?php else: ?>
                    <?php foreach ($premierTicket as $ticket): ?>
                        <input type="hidden" id="idTicket" value="<?php echo $ticket['idTicket'] ?>">
                        <?php echo " <p id='numTicketCourant'>" . $ticket["num_ticket"] . "</p>" ?>
                        <p id="nomServiceCourant">  <?php echo $ticket["nomService"] ?></p>
                        <p id="numeroGuichet"> <?php echo $ticket["nom_guichet"] ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
         </div>

    <?php
    /** @var Publicite[] $publicites * */
    ?>
        <div class="divPublicite">
                <?php foreach ($publicites as $key => $publicite): ?>
            <?php if ($publicite->getEstActif()):?>
            <?php if ($publicite->getType() === enumPublicite::VIDEO ):?>
                            <iframe class="imgPub" src="<?php
                            $videoUrl = $publicite->getFichier();
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
                            $videoId = isset($matches[1]) ? $matches[1] : '';
                            echo "https://www.youtube.com/embed/" . $videoId . "?autoplay=1&mute=1&loop=1&playlist=" . $videoId;
                            ?>" title="YouTube video player" allow="autoplay" frameborder="0" allowfullscreen></iframe>
                        <?php else:?>
                    <img class="imgPub <?= $key === 0 ? 'active' : 'hidden' ?>"
                         src="<?= $publicite->getFichier() ?>"
                         alt="Publicité"
                         data-index="<?= $key ?>">
            <?php endif; ?>
            <?php endif; ?>
                <?php endforeach;?>
            <div class="divTemperature">
                <p id="horloge"> </p>
            </div>


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
                        <?php $nomService = htmlspecialchars($s->getNomService());
                        echo "<h3 class='h3Service'>" . $nomService . "</h3>"; ?>
                    </div>
                    <div class="nbPersonneAttenteDiv">
                        <?php $nbPersonne = (new ServiceRepository())->getNbPersonneAttente($s->getIdService());
                        echo "<p class='nbPersonneAttenteFile'> $nbPersonne</p>" ?>
                        <p class="texteEnAttente"> en attente</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="colonneDroite">
        <div class="derniersAppels">
            <h2> Derniers appels </h2>
            <?php
            /** @var Ticket[] $tickets */
            ?>
            <?php foreach ($tickets as $ticket): ?>
                <div class="service-div">
                    <div class="numTicketNomServiceDiv">
                        <?php $numTicket = $ticket['num_ticket'];
                        echo "<h3 class='h3Service'>" . $numTicket . "</h3>";
                        echo "<p>" . $ticket['nomService'] . "</p>";
                        ?>
                    </div>
                    <div class="numGuichetStatutDiv">
                        <?php $numGuichet = $ticket['nom_guichet'];
                        echo "<p>" . $numGuichet . "</p>";
                        $statut = $ticket['statutTicket'];
                        if ($statut == 'en attente') {
                            $statut = "<div class='statutEnAttente' id='" . $ticket['idTicket'] . "'>" . $statut . "</div>";
                        } else if ($statut == 'terminé') {
                            $statut = "<div class='statutTermine' id='" . $ticket['idTicket'] . "'>" . $statut . "</div>";
                        }
                        echo $statut;
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>


