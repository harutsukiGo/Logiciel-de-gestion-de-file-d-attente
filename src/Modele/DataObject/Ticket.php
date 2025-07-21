<?php
namespace App\file\Modele\DataObject;

use DateTime;

class Ticket extends AbstractDataObject{

    private ?int $idTicket;
    private string $num_ticket;
    private DateTime $date_heure;
    private string $statutTicket;
    private ?Historique $idHistorique;
    private ?Agents $idAgent;
    private ?DateTime $date_arrivee;
    private ?DateTime $date_terminee;

    /**
     * @param int|null $idTicket
     * @param string $num_ticket
     * @param DateTime $date_heure
     * @param string $statutTicket
     * @param Historique|null $idHistorique
     * @param Agents|null $idAgent
     * @param DateTime|null $date_arrivee
     * @param DateTime|null $date_terminee
     */
    public function __construct(?int $idTicket, string $num_ticket, DateTime $date_heure, string $statutTicket, ?Historique $idHistorique, ?Agents $idAgent, ?DateTime $date_arrivee, ?DateTime $date_terminee)
    {
        $this->idTicket = $idTicket;
        $this->num_ticket = $num_ticket;
        $this->date_heure = $date_heure;
        $this->statutTicket = $statutTicket;
        $this->idHistorique = $idHistorique;
        $this->idAgent = $idAgent;
        $this->date_arrivee = $date_arrivee;
        $this->date_terminee = $date_terminee;
    }


    public function getIdTicket(): ?int {
        return $this->idTicket;
    }
    public function getNumTicket(): string {
        return $this->num_ticket;
    }
    public function getDateHeure(): DateTime {
        return $this->date_heure;
    }
    public function getStatutTicket(): string {
        return $this->statutTicket;
    }
    public function getIdHistorique(): ?Historique {
        return $this->idHistorique;
    }
    public function getIdAgent(): ?Agents {
        return $this->idAgent;
    }
    public function getDateArrivee(): ?DateTime {
        return $this->date_arrivee;
    }
    public function getDateTerminee(): ?DateTime {
        return $this->date_terminee;
    }



}



