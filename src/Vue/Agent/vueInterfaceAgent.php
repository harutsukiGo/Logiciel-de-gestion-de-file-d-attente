<?php
/** @var Agents $agent */

use App\file\Controleur\ControleurTicket;
use App\file\Lib\ConnexionUtilisateur;
use App\file\Modele\DataObject\Agents;
use App\file\Modele\DataObject\Historique;
use App\file\Modele\DataObject\Service;
use App\file\Modele\DataObject\Ticket;

?>
<section class="sectionInterfaceAgent">
    <div class="divButtonAgent">
        <button id="btnRetourAgent" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?'">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-arrow-left w-5 h-5" style="vertical-align: middle; margin-right: 5px;">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>
            <span>Retour à l'accueil</span>
        </button>
    </div>
    <div class="header-interfaceAgent">
        <div class="titreInterfaceAgent">
            <h1 class=>Interface Agent</h1>
            <input type="hidden" id="idGuichetAgent" value="<?php echo $agent->getIdGuichet()->getIdGuichet();?>">
            <?php echo "<p class=''>" . "Poste de travail : " . "Guichet " . $agent->getIdGuichet()->getIdGuichet() . "</p>"; ?>
        </div>

        <div class="agentInfo">
            <input type="hidden" id="idAgent" value="<?php echo $agent->getIdAgent() ?>">

            <?php $statut = $agent->getStatut();
            if ($statut): ?>
                <?php echo "<div class='statutAgentOuvert'  id='divStatutAgent' >" . "Ouvert" . "</div>"; ?>
            <?php else: ?>
                <?php echo "<div class='statutAgentFerme' id='divStatutAgent'>" . "Fermé" . "</div>"; ?>
            <?php endif; ?>
            <?php echo "<span class=''>" . "Agent : " . $agent->getNomAgent() . "</span>"; ?>
        </div>
    </div>
</section>

<section class="sectionInterfaceAgent">
    <div class="divInterfaceAgent">


        <div class="colonneGauche">
            <div class="divClientActuel">
                <div class="titreClientActuel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-user h-5 w-5">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <h2>Client actuel</h2>
                </div>


                <div id="infoTicketCourant">
                    <p> Aucun client en cours de service
                    </p>
                    <button id="appelerSuivant" onclick="appelerSuivant()"
                            style="display: flex; align-items: center; gap: 8px; justify-content: center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone w-5 h-5">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>Appeler le suivant</span>
                    </button>
                </div>
            </div>


            <div class="controlePosteAgent">
                <h2>Contrôle du poste </h2>
                <div class="divBoutonPosteAgent">
                    <button id="btnOuvrir" data-statut="1" data-info="Ouvert" class="btnOuvrir"
                            onclick="mettreAJourStatutAgentOuvert()"
                            style="display: flex; align-items: center; gap: 8px;     justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-play">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                        <span>Ouvrir</span>
                    </button>
                    <button id="btnFermer" data-statut="0" data-info="Fermé" class="btnFermer"
                            onclick="mettreAJourStatutAgentFermer()"
                            style="display: flex; align-items: center; gap: 8px; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span>Fermer</span>
                    </button>
                </div>
            </div>

            <div class="redirectionTickets">
                <h2> Redirection de ticket</h2>
                <p>Rediriger un client vers un autre service</p>

                <div class="divInput">
                    <div class="divNumTicket">
                        <p> Numéro du ticket</p>
                        <label for="numTicketRedirection">
                            <select id="numTicketRedirection">
                                <?php /** @var Ticket[] $tickets * */ ?>
                                <?php foreach ($tickets as $ticket): ?>
                                    <option id="inputIdTicket" value="<?php echo $ticket["idTicket"]; ?>">
                                        <?php echo $ticket["num_ticket"]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>

                    <div class="divServiceDeroulant">
                        <p> Services </p>
                        <label for="serviceDeroulant">
                            <select id="serviceDeroulant">
                                <?php /** @var Service[] $services * */ ?>
                                <?php foreach ($services as $service): ?>
                                    <option id="inputIdService" value="<?php echo $service["idService"]; ?>">
                                        <?php echo $service["nomService"]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                </div>
                <button id="btnRediriger" class="btnRediriger"
                        style="display: flex; align-items: center; gap: 8px; justify-content: center;"
                        onclick="redirigerTicket()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-forward h-4 w-4 mr-2">
                        <polyline points="15 17 20 12 15 7"></polyline>
                        <path d="M4 18v-2a4 4 0 0 1 4-4h12"></path>
                    </svg>
                    Rediriger
                </button>
            </div>


        </div>
        <div class="colonneDroite">
            <div class="sessionActuel">
                <h2> Session actuelle</h2>
                <div class="divSessionActuel">
                    <span> Début session :</span>
                    <span><?php echo ConnexionUtilisateur::retourneHeureConnexionAgent() ?></span>
                </div>
                <div class="divSessionActuel">
                    <span> Clients servis :</span>
                    <span>                    <?php echo (new ControleurTicket())->compterClientServi() ?>
</span>
                </div>
                <div class="divSessionActuel">
                    <span> Temps moyen :</span>
                    <span> <?php echo ConnexionUtilisateur::tempsMoyen() ?></span>
                </div>
            </div>


            <div>
                <?php
                /** @var Ticket[] $tickets */
                ?>
                <div class="fileAttenteAgent">
                    <h2> File d'attente</h2>
                    <?php if (count($tickets) == 0): ?>
                        <p>Aucun ticket en attente</p>

                    <?php else: ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <div class="divFilAttente">
                                <div class="divNumTicket">
                                    <span><?php echo $ticket["num_ticket"]; ?></span>
                                </div>
                                <p class="nomServiceAgent"><?php echo $ticket["nomService"] ?> </p>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>
            </div>

            <?php
            /** @var Historique[] $historique */
            ?>
            <div class="historiqueAgent">
                <h2> Historique des tickets</h2>
                <?php if (count($historique) == 0): ?>
                    <p>Aucun ticket dans l'historique</p>
                <?php else: ?>
                    <?php foreach ($historique as $ticket): ?>
                        <div class="divHistorique">
                            <div class="divNumTicket">
                                <span><?php echo $ticket["num_ticket"]; ?></span>
                            </div>
                            <p class="nomServiceAgent"><?php echo $ticket["nomService"] ?> </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
</section>