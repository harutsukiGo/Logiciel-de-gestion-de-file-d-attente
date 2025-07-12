<?php
namespace App\file\Modele\DataObject;

use DateTime;

class Historique extends AbstractDataObject
{
    private ?int $idHistorique;
    private string $statut;
    private DateTime $date_heure;
    private string $action;
    private Ticket $idTicket;
    private Agents $idAgent;

    public function __construct(?int $idHistorique, string $statut, DateTime $date_heure, string $action, Ticket $idTicket, Agents $idAgent)
    {
        $this->idHistorique = $idHistorique;
        $this->statut = $statut;
        $this->date_heure = $date_heure;
        $this->action = $action;
        $this->idTicket = $idTicket;
        $this->idAgent= $idAgent;
    }
    public function getIdHistorique(): ?int
    {
        return $this->idHistorique;
    }
    public function getStatut(): string
    {
        return $this->statut;
    }
    public function getDateHeure(): DateTime
    {
        return $this->date_heure;
    }
    public function getAction(): string
    {
        return $this->action;
    }
    public function getIdTicket(): Ticket
    {
        return $this->idTicket;
    }
    public function getIdAgent(): Agents
    {
        return $this->idAgent;
    }
}