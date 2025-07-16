<section>
    <div class="grilleService">
        <?php
        /** @var Service[] $services */
        use App\file\Modele\Repository\ServiceRepository;

        ?>

        <?php foreach ($services as $s): ?>
                <?php if ($s->getStatutService()): ?>
                <div class="liste-service-item">
                    <a class="aService"
                       href="/fileAttente/web/controleurFrontal.php?action=afficherDetail&controleur=service&idService=<?php echo $s->getIdService(); ?>">
                        <?php $nomService = htmlspecialchars($s->getNomService()); ?>
                        <?php echo "<p class='titreService'>$nomService</p>"; ?>
                        <?php $nbPersonneAttente = (new ServiceRepository())->getNbPersonneAttente($s->getIdService()); ?>
                        <div class="service-info">
                            <?php echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgb(55, 65, 81)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-12 h-12"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'; ?>
                            <?php echo "<p class='nbPersonneAttente'>$nbPersonneAttente en attente</p>"; ?>
                        </div>
                        <?php
                        echo "<div class='statutActif'>Service actif</div>";
                        ?>
                    </a>
                </div>
                <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>