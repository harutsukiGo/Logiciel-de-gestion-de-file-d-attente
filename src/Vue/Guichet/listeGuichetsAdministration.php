<?php
/** @var Guichets[] $guichets */ ?>
<?php use App\file\Modele\DataObject\Guichets;
use App\file\Modele\Repository\GuichetsRepository; ?>

<section class="headerServiceAdministration">
    <h2> Gestion des guichets</h2>
    <button id="btnNouveauService" onclick="modalGuichet(null,null,null,ajouterGuichet)">
        <span> + Nouveau guichet </span>
    </button>
</section>


<section class="sectionGuichetsAdministration">
    <?php foreach ($guichets as $guichet): ?>
        <?php if ($guichet["estActif"]): ?>
            <div class="divGuichet" data-id-guichet="<?php echo $guichet["idGuichet"]; ?>">
                <div class="divParentStatistiqueStatut">
                <div class="divParametresGuichet">
                    <?php echo "<p class='titreServiceAdmin'>" .$guichet["nom_guichet"]. "</p>"?>
                    <?php $listeAgent= (new GuichetsRepository())->recupererAgentGuichet($guichet["idGuichet"]); ?>
                     <?php if (count($listeAgent) == 0): ?>
                    <?php echo "<p class='nbPersonneAttenteAdmin'> Aucun agent n'est attribué </p>" ?>

                    <?php else:?>
                        <?php
                            echo "<p class='nbPersonneAttenteAdmin'>Agents : ";
                            $noms = array_map(fn($a) => $a["nomAgent"], $listeAgent);
                            echo implode('<br> ', $noms);
                            echo "</p>";
                        ?>
                     <?php endif;?>


                    <?php if ($guichet["nomService"]==null):
                        echo"<p class='nbPersonneAttenteAdmin'>" . "Aucun service n'est attribué  " . "</p>" ?>
                    <?php else:?>
                        <?php echo"<p class='nbPersonneAttenteAdmin'>" . "Service : " . $guichet["nomService"]. "</p>" ?>
                    <?php endif;?>
                </div>
                    <?php
                    $statut = $guichet["statutGuichet"];

                    if ($statut) {
                        echo "<div class='statutTermine'>Actif</div>";
                    } else {
                        echo "<div class='statutInactifAdmin'>Inactif</div>";
                    }
                    ?>
                </div>
                <div class="actionsServices">

                    <button id="btnModifierService" onclick="modalGuichet(
                            '<?php echo $guichet["nom_guichet"]?>',
                            '<?php echo $guichet["statutGuichet"]?>',
                            '<?php echo $guichet["idService"]?>',
                            () => mettreAJourGuichet('<?php echo $guichet["idGuichet"]?>'))">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen w-4 h-4"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                    </button>

                    <button id="btnSupprimerService" onclick="supprimerGuichet('<?php echo $guichet["idGuichet"]?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</section>