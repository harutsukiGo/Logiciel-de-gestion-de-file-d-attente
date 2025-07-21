<section class="intro">
    <h1>Système de Gestion de File d'Attente</h1>
    <div class="description"><p> Solution complète pour optimiser l'accueil de vos clients et réduire les temps
            d'attente</p></div>
</section>

<section class="header-statistiques">
    <div class="grille">
        <div class="tickets">
            <div class="ticket-info">
                <p>Tickets aujourd'hui</p>
                <p class="nombreTicket"><?php

                    use App\file\Modele\Repository\ServiceRepository;
                    use App\file\Modele\Repository\TicketRepository;

                    $date = new DateTime('now');
                    echo (new TicketRepository())->compteTicket(); ?>
                </p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                 stroke="#1E90FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-users w-12 h-12">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>

        <div class="temps">
            <div class="temps-info">
                <p>Temps d'attente moyen</p>
                <p class="nombreTemps"><?php echo (new TicketRepository())->getTempsAttenteMoyen(); ?></p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                 stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-clock w-8 h-8 text-green-600">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div class="files">
            <div class="files-info">
                <p>Services actifs</p>
                <p class="nombreFiles">
                    <?php $nbServices = (new ServiceRepository())->retourneNombreServices();
                    echo $nbServices;?></p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                 stroke="purple" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-alert-circle w-8 h-8 text-purple-600">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" x2="12" y1="8" y2="12"></line>
                <line x1="12" x2="12.01" y1="16" y2="16"></line>
            </svg>
        </div>
    </div>
</section>

<section class="modules">
    <div class="grille_module">

        <div class="borneAccueil">
            <div class="borneAccueil-descriptionParent">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                     stroke="rgb(37 99 235)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-tablet w-8 h-8 text-white">
                    <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                    <line x1="12" x2="12.01" y1="18" y2="18"></line>
                </svg>
                <div class="borneAccueil-description">
                    <p class="titre">Borne d'accueil</p>
                    <p>Interface tactile pour la prise de tickets</p>
                </div>
            </div>
            <div class="borneAccueil-bulletPoint">
                <ul>
                    <li>Écran tactile</li>
                    <li>Impression tickets</li>
                    <li>Sélection service</li>
                </ul>
            </div>
            <button id="borneAccueil-btn"
                    onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherService&controleur=service'">
                Accéder au module
            </button>
        </div>


        <div class="affichageSalle">
            <div class="affichageSalle-descriptionParent">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                     stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-monitor w-8 h-8 text-white">
                    <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                    <line x1="8" x2="16" y1="21" y2="21"></line>
                    <line x1="12" x2="12" y1="17" y2="21"></line>
                </svg>
                <div class="affichageSalle-description">
                    <p class="titre">Affichage salle d'attente</p>
                    <p>Écran de diffusion pour les clients</p>
                </div>
            </div>
            <div class="affichageSalle-bulletPoint">
                <ul>
                    <li>Appels en cours</li>
                    <li>Publicités</li>
                    <li>Informations</li>
                </ul>
            </div>
            <button id="affichageSalle-btn"
                    onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=affichageSalleAttente&controleur=ticket'">
                Accéder au module</button>
        </div>

        <div class="interfaceAgent">
            <div class="interfaceAgent-descriptionParent">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                     stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-user w-4 h-4">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <div class="interfaceAgent-description">
                    <p class="titre">Interface agent</p>
                    <p>Poste de travail pour les agents</p>
                </div>
            </div>
            <div class="interfaceAgent-bulletPoint">
                <ul>
                    <li>Appels tickets</li>
                    <li>Gestion file</li>
                    <li>Historique</li>
                </ul>
            </div>
            <button id="interfaceAgent-btn"> Accéder au module</button>
        </div>


        <div class="administration">
            <div class="administration-descriptionParent">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                     stroke="purple" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-settings w-4 h-4">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <div class="administration-description">
                    <p class="titre">Administration </p>
                    <p>Poste de travail pour les agents</p>
                </div>
            </div>
            <div class="administration-bulletPoint">
                <ul>
                    <li>Configuration</li>
                    <li>Statistiques</li>
                    <li>Utilisateurs</li>
                </ul>
            </div>
            <button id="administration-btn"> Accéder au module</button>
        </div>
    </div>
</section>