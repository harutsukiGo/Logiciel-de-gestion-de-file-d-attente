<?php
use App\file\Lib\ConnexionUtilisateur;
use App\file\Modele\Repository\AgentRepository;
 ob_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        /** @var string $titre*/
        echo $titre;?></title>
    <script src="/fileAttente/ressources/js/script.js"></script>
    <script src="/fileAttente/ressources/js/Modal.js"></script>
    <link rel="stylesheet" href="/fileAttente/ressources/css/style.css">
</head>
<body>
<header>
    <div id="logo">QueueApp</div>
    <nav>
        <div><a href="/fileAttente/web/controleurFrontal.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-home w-4 h-4">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Accueil</a></div>
        <div><a href="/fileAttente/web/controleurFrontal.php?action=afficherService&controleur=service">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-tablet w-4 h-4">
                    <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                    <line x1="12" x2="12.01" y1="18" y2="18"></line>
                </svg>
                Borne d'accueil</a></div>
        <div><a href="/fileAttente/web/controleurFrontal.php?action=affichageSalleAttente&controleur=ticket">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-monitor w-4 h-4">
                    <rect width="20" height="14" x="2" y="3" rx="2"></rect>
                    <line x1="8" x2="16" y1="21" y2="21"></line>
                    <line x1="12" x2="12" y1="17" y2="21"></line>
                </svg>
                Affichage salle</a></div>
        <?php if (ConnexionUtilisateur::estConnecte()):
            echo "<div><a href='/fileAttente/web/controleurFrontal.php?action=afficherAgent&controleur=agent&idAgent=" . ConnexionUtilisateur::getLoginUtilisateurConnecte() . "'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-user w-4 h-4'><path d='M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2'></path><circle cx='12' cy='7' r='4'></circle></svg> Interface agent</a></div>";
            echo '<div><a href="/fileAttente/web/controleurFrontal.php?action=afficherAdministration&controleur=administration"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings w-4 h-4"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>Administration</a></div>';
        endif;?>
    </nav>
    <?php if(!ConnexionUtilisateur::estConnecte()):?>
        <div class="connexion"><a
                    href="/fileAttente/web/controleurFrontal.php?action=afficherAuthentification&controleur=agent">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-user w-4 h-4">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Connexion</span></a></div>
    <?php else:?>
        <div class="connexion">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-user w-4 h-4">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <a href='/fileAttente/web/controleurFrontal.php?action=afficherDetail&controleur=agent&idAgent=<?php echo ConnexionUtilisateur::getLoginUtilisateurConnecte(); ?>'>
                Agent <?php echo (new AgentRepository())->recupererParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getNomAgent()?></a>
        </div>
    <?php endif;?>
</header>
<main>
    <?php
    /** @var string $cheminCorpsVue */
$listeChemins = [
    "Administration/vueAdministration.php",
    "Publicite/listePublicitesAdministration.php",
    "Guichet/listeGuichetsAdministration.php",
    "Service/listeServiceAdministration.php",
    "Agent/listeAgentAdministration.php"
];
if (in_array($cheminCorpsVue, $listeChemins)):?>
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

            <button id="btnPublicites" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherPublicitesAdministration&controleur=publicite'">
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


            <button id="btnGuichets" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherGuichetsAdministration&controleur=guichet'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M3990 5104 c-266 -57 -470 -311 -470 -584 0 -324 276 -600 600 -600 276 0 528 205 585 475 43 204 -16 397 -164 546 -149 149 -347 207 -551 163z m236 -416 c19 -13 47 -41 62 -62 23 -33 27 -50 27 -106 0 -56 -4 -73 -27 -106 -46 -65 -91 -89 -168 -89 -54 0 -73 5 -103 25 -77 52 -111 140 -88 227 13 48 79 119 125 133 49 15 133 4 172 -22z"/><path d="M1280 5094 c-266 -57 -470 -311 -470 -584 0 -324 276 -600 600 -600 276 0 528 205 585 475 43 204 -16 397 -164 546 -149 149 -347 207 -551 163z m236 -416 c19 -13 47 -41 62 -62 23 -33 27 -50 27 -106 0 -56 -4 -73 -27 -106 -46 -65 -91 -89 -168 -89 -54 0 -73 5 -103 25 -77 52 -111 140 -88 227 13 48 79 119 125 133 49 15 133 4 172 -22z"/><path d="M3590 3714 c-223 -48 -409 -237 -456 -463 -13 -63 -15 -168 -12 -700 l3 -626 23 -65 c56 -156 169 -288 299 -351 l72 -34 3 -670 3 -670 24 -38 c13 -21 42 -50 64 -65 34 -22 52 -27 106 -27 79 0 128 25 169 88 l27 41 0 785 0 786 -24 38 c-35 57 -84 85 -171 97 -85 12 -130 38 -170 97 l-25 37 0 611 0 612 27 39 c15 21 44 50 65 64 l37 25 466 0 466 0 37 -25 c21 -14 50 -43 65 -64 l27 -39 0 -612 0 -611 -25 -37 c-40 -59 -85 -85 -170 -97 -87 -12 -136 -40 -171 -97 l-24 -38 0 -785 0 -785 24 -38 c13 -21 42 -50 64 -65 34 -23 52 -27 107 -27 55 0 73 4 107 27 22 15 51 44 64 65 l24 38 3 670 3 670 72 34 c130 63 243 195 299 351 l23 65 3 626 c3 532 1 637 -12 700 -48 229 -234 416 -461 464 -99 21 -958 20 -1055 -1z"/><path d="M830 3664 c-221 -47 -408 -236 -455 -459 -12 -55 -15 -162 -15 -511 l0 -442 -112 -3 c-130 -5 -169 -21 -216 -92 l-27 -41 -3 -1058 -2 -1058 1492 2 1493 3 38 24 c21 13 50 42 65 64 23 34 27 52 27 107 0 55 -4 73 -27 107 -15 22 -44 51 -65 64 l-38 24 -1292 3 -1293 2 0 725 0 725 1093 2 1093 3 41 27 c63 41 88 90 88 169 0 54 -5 72 -27 106 -15 22 -44 51 -65 64 l-38 24 -913 3 -913 2 3 449 3 448 27 39 c15 21 44 50 65 64 l37 25 466 0 466 0 37 -25 c21 -14 50 -43 65 -64 26 -38 27 -43 32 -221 5 -176 6 -183 32 -222 41 -63 90 -88 169 -88 54 0 72 5 106 27 22 15 51 44 64 65 22 35 24 49 27 208 3 126 -1 190 -12 245 -48 230 -234 417 -461 465 -99 21 -958 20 -1055 -1z"/></g></svg>
                <span>
             Guichets
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
       <?php endif ?>

        <?php require __DIR__ . "/{$cheminCorpsVue}";?>
</main>
</body>
</html>