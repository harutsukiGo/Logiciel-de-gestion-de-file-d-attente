<section class="header-statistiques">
     <div class="grille">
         <div class="tickets">
             <div class="ticket-info">
                 <p>Tickets aujourd'hui</p>
                 <p class="nombreTicket">
                     <?php

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