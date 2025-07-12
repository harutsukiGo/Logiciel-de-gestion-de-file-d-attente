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


    public function __construct(?int $idTicket, string $num_ticket, DateTime $date_heure, string $statutTicket, ?Historique $idHistorique, ?Agents $idAgent) {
        $this->idTicket = $idTicket;
        $this->num_ticket = $num_ticket;
        $this->date_heure = $date_heure;
        $this->statutTicket = $statutTicket;
        $this->idHistorique = $idHistorique;
        $this->idAgent = $idAgent;
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



}



