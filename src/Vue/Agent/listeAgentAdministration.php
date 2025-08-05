<?php /** @var Agents[] $agents */

use App\file\Modele\Repository\AgentRepository; ?>

<section class="headerServiceAdministration">
    <h2> Gestion des agents</h2>
    <button id="btnNouveauService" onclick="modalAgent(null, null, null, null, null, null, null,null,ajouterAgent)">
        <span> + Nouvel agent </span>
    </button>
</section>

<section>
        <?php foreach ($agents as $agent): ?>
        <?php  if ($agent->getEstActif()):?>
            <div class="divService" data-id-service="<?php echo $agent->getIdAgent(); ?>">
                <div>
                    <p class="titreServiceAdmin"> <?php echo $agent->getNomAgent(); ?></p>
                    <p class="nbPersonneAttenteAdmin"> <?php echo $agent->getMailAgent(); ?></p>
                </div>

                <div>
                    <?php echo "<p>" . $agent->getIdGuichet()->getNomGuichet() . "</p>" ?>
                </div>


                <div class="statutAgent">
                    <?php
                    $statut = $agent->getStatut();
                    if ($statut) {
                        echo "<div class='statutTermine'>Disponible</div>";
                    } else {
                        echo "<div class='statutInactifAdmin'>Hors ligne</div>";
                    }
                    ?>
                </div>

                <div class="divListeServices">
                    <?php $services = (new AgentRepository())->recupererServicesParAgent($agent->getIdAgent());
                        foreach ($services as $service) {
                            echo "<div class='divStatutAgent'>" . $service["nomService"] . "</div>";
                    }
                    ?>
                </div>
                <div class="actionsServices">
                    <button id="btnModifierService" onclick="modalAgent(
                            '<?php echo $agent->getNomAgent();?>',
                            '<?php echo $agent->getMailAgent() ?>',
                             '<?php echo $agent->getStatut()?>',
                            '<?php echo $agent->getLogin() ?>',
                            '<?php echo $agent->getMotDePasse() ?>',
                            '<?php echo $agent->getRole() ?>',
                            '<?php echo $agent->getIdGuichet()->getIdGuichet() ?>',
                            '<?php echo $agent->getIdService()->getIdService() ?>',
                            () =>  mettreAJourAgent('<?php echo $agent->getIdAgent() ?>'))">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-pen w-4 h-4">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                        </svg>
                    </button>
                    <button id="btnSupprimerService" onclick="supprimerAgent('<?php echo $agent->getIdAgent() ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-trash2 w-4 h-4">
                            <path d="M3 6h18"></path>
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                            <line x1="10" x2="10" y1="11" y2="17"></line>
                            <line x1="14" x2="14" y1="11" y2="17"></line>
                        </svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </section>
</section>
