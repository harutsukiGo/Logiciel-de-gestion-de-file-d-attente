<?php /** @var Services[] $services */?>
<section class="sectionServiceAdministration">
<section class="sectionAdministrationHeader">
    <button id="btnRetourAgent" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-arrow-left w-5 h-5" style="vertical-align: middle; margin-right: 5px;">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        <span>Retour</span>
    </button>
    <h2> Administration</h2>
</section>

<section class="selectionVue">

    <button id="btnVueEnsemble"
            onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherAdministration&controleur=administration'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-bar-chart3 w-4 h-4">
            <path d="M3 3v18h18"></path>
            <path d="M18 17V9"></path>
            <path d="M13 17V5"></path>
            <path d="M8 17v-3"></path>
        </svg>
        <span> Vue d'ensemble</span>
    </button>


    <button id="btnServices"
            onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherServiceAdministration&controleur=service'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-settings w-4 h-4">
            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
        <span>Services</span>
    </button>

    <button id="btnAgents" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherListeAgentAdministration&controleur=agent'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-users w-4 h-4">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
        <span>
             Agents
         </span>
    </button>

    <button id="btnPublicites">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-megaphone w-4 h-4">
            <path d="m3 11 18-5v12L3 14v-3z"></path>
            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path>
        </svg>
        <span>
            Publicités
         </span>
    </button>

    <button id="btnParametres">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-monitor w-4 h-4">
            <rect width="20" height="14" x="2" y="3" rx="2"></rect>
            <line x1="8" x2="16" y1="21" y2="21"></line>
            <line x1="12" x2="12" y1="17" y2="21"></line>
        </svg>
        <span>
             Paramètres
         </span>
    </button>
</section>

<section class="headerServiceAdministration">
    <h2> Gestion des services</h2>
    <button id="btnNouveauService" onclick="modalService(null, null,null,null,ajouterService)">
        <span> + Nouveau service </span>
    </button>
</section>

<section>
    <?php foreach ($services as $service): ?>
    <?php  if ($service->getEstActif()):?>
        <div class="divService" data-id-service="<?php echo $service->getIdService(); ?>">
            <div class="divNomServiceHoraireStatut">
                <div class="divNomServiceHoraire">
                    <?php echo "<p class='titreServiceAdmin'>" . $service->getNomService() . "</p>"; ?>
                    <?php echo "<p class='nbPersonneAttenteAdmin'>" . "Horaires : " . $service->getHoraireDebut()->format('H:i') . " - " . $service->getHoraireFin()->format('H:i') . "</p>"; ?>
                </div>
                <?php
                $statut = $service->getStatutService();
                if ($statut) {
                    echo "<div class='statutTermine'>Actif</div>";
                } else {
                    echo "<div class='statutInactifAdmin'>Inactif</div>";
                }
                ?>
            </div>

            <div class="actionsServices">
                    <button id="btnModifierService"
                            onclick="modalService(
                                    '<?php echo ($service->getNomService()) ?>',
                                    '<?php echo $service->getHoraireDebut()->format('H:i') ?>',
                                    '<?php echo $service->getHoraireFin()->format('H:i') ?>',
                            <?php echo $service->getStatutService() ? 'true' : 'false'; ?>,
                                    () => mettreAJourService('<?php echo $service->getIdService(); ?>'))">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen w-4 h-4"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                </button>
                <button id="btnSupprimerService" onclick="supprimerService(<?php echo $service->getIdService(); ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                </button>
            </div>


        </div>
    <?php endif; ?>
    <?php endforeach; ?>
</section>
</section>
