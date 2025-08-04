<section class="headerServiceAdministration">
        <h2> Gestion des publicités</h2>
        <button id="btnNouveauService" onclick="modalPublicite(null,null,null,null,ajouterPublicite)">
            <span> + Nouvel publicité </span>
        </button>
    </section>

    <?php /** @var Publicite[] $publicites **/

    use App\file\Modele\DataObject\enumPublicite;
    use App\file\Modele\DataObject\Publicite;
    ?>



    <section>
        <div class="divPubliciteAdministration">
        <?php foreach ($publicites as $publicite): ?>
        <?php if ($publicite->getEstActif()):?>
        <div class="divPubliciteChild">
         <?php if ($publicite->getType() === enumPublicite::VIDEO):?>
             <iframe class="imgPubliciteAdmin" src="<?php echo $publicite->getFichier()?>" title="YouTube video player" allow="autoplay"></iframe>
         <?php else: ?>
         <img class="imgPubliciteAdmin" src="<?php echo $publicite->getFichier()?>" alt="pub">
            <?php endif; ?>

            <div class="bottomAction">

            <div class="divStatutOrdre">
              <?php $statut=$publicite->getActif();
              if ($statut) {
                  echo "<div class='statutActifPub'>Actif</div>";
              } else {
                  echo "<div class='statutInactifAdmin'>Inactif</div>";
              }
              ?>
                   <span class="ordre"> Ordre : <?php echo $publicite->getOrdre();?></span>
            </div>

            <div class="divParentsBtnFleche">

            <div class="divButtonFleche">
                <button id="btnHaut" onclick="augmenterOrdrePub(<?php echo $publicite->getIdPublicite();?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up w-4 h-4"><path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path></svg>
                </button>

                <button id="btnBas" onclick="diminuerOrdrePub(<?php echo $publicite->getIdPublicite();?>)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down w-4 h-4"><path d="M12 5v14"></path><path d="m19 12-7 7-7-7"></path></svg>
                </button>
            </div>

            <div class="divButtonPublicite">
                 <button id="btnModifierService"
                        onclick="modalPublicite(
                                '<?php echo $publicite->getFichier() ?>',
                                '<?php echo $publicite->getOrdre() ?>',
                                '<?php echo $publicite->getActif() ?>',
                                '<?php echo $publicite->getType()->getValue() ?>',
                                () => mettreAJourPublicite('<?php echo $publicite->getIdPublicite() ?>'))">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-pen w-4 h-4">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                    </svg>
                </button>

                <button id="btnSupprimerService" onclick="supprimerPublicite('<?php echo $publicite->getIdPublicite() ?>')">
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

            </div>


        </div>
            <?php endif; ?>
       <?php endforeach; ?>
        </div>
</section>
