<?php /** @var Services[] $services */?>
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
                                    '<?php echo $service->getStatutService()?>',
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
