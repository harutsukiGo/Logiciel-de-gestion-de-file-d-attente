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
<button id="btnVueEnsemble" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherAdministration&controleur=administration'">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bar-chart3 w-4 h-4"><path d="M3 3v18h18"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>
    <span> Vue d'ensemble</span>
</button>


     <button id="btnServices" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherServiceAdministration&controleur=service'">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings w-4 h-4"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
         <span>Services</span>
     </button>

     <button id="btnAgents" onclick="window.location.href='/fileAttente/web/controleurFrontal.php?action=afficherListeAgentAdministration&controleur=agent'">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-4 h-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
         <span>
             Agents
         </span>
     </button>

     <button id="btnPublicites">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone w-4 h-4"><path d="m3 11 18-5v12L3 14v-3z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path></svg>
         <span>
            Publicités
         </span>
     </button>

     <button id="btnParametres">
         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-4 h-4"><rect width="20" height="14" x="2" y="3" rx="2"></rect><line x1="8" x2="16" y1="21" y2="21"></line><line x1="12" x2="12" y1="17" y2="21"></line></svg>
         <span>
             Paramètres
         </span>
     </button>
 </section>



 <section class="header-statistiques">
     <div class="grille">
         <div class="tickets">
             <div class="ticket-info">
                 <p>Tickets aujourd'hui</p>
                 <p class="nombreTicket">
                     <?php
                     use App\file\Lib\ConnexionUtilisateur;
                     use App\file\Modele\Repository\ServiceRepository;
                     use App\file\Modele\Repository\TicketRepository;
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

 <section>
     <div class="grilleAdmin">

         <div class="divActiviteServices">
             <h3>Activité des services</h3>
             <?php /** @var Services[] $services **/ ?>
             <?php foreach ($services as $service):?>

             <div class="divChildActiviteServices">

              <div class="nomServiceNbPersonne">
                <?php echo "<p class='titreServiceAdmin'>".$service->getNomService()."</p>";?>
                <?php  echo "<p class='nbPersonneAttenteAdmin'>" .(new ServiceRepository())->getNbPersonneAttente($service->getIdService()) ." en attente</p>";?>
              </div>

                 <div class="statutNbTickets">
                     <?php echo "<p class='nbTicketService'>" .(new TicketRepository())->nbTicketParService($service->getIdService()) . " tickets"."</p>";?>
                     <?php $statut= $service->getStatutService();
                     if ($statut) {
                         $statut = "<div class='statutTermine'> Ouvert ". "</div>";
                     }
                     else {
                         $statut = "<div class='statutInactifAdmin'> Fermé "."</div>";
                     }
                     echo $statut;
                     ?>
                 </div>
             </div>
             <?php endforeach ?>
         </div>

         <div class="divPerformanceAgents">
             <h3>Performances des agents</h3>
             <?php /** @var Agents[] $agents **/ ?>
             <?php foreach ($agents as $agent):?>

                 <div class="divChildActiviteServices">

                     <div class="nomServiceNbPersonne">
                         <?php echo "<p class='titreServiceAdmin'>".$agent->getNomAgent()."</p>";?>
                         <?php  echo "<p class='nbPersonneAttenteAdmin'> Guichet ". $agent->getIdGuichet()->getIdGuichet()."</p>";?>
                     </div>

                     <div class="statutNbTickets">
                         <?php echo "<p class='nbTicketService'>" .(new TicketRepository())->compterNombreClient($agent->getIdAgent()) . " tickets"."</p>";?>
                         <?php $statut= $agent->getStatut();
                         if ($statut) {
                             $statut = "<div class='statutTermine'> Disponible ". "</div>";
                         }
                         else {
                             $statut = "<div class='statutInactifAdmin'> Occupé "."</div>";
                         }
                         echo $statut;
                         ?>
                     </div>
                 </div>
             <?php endforeach ?>
         </div>





     </div>
 </section>