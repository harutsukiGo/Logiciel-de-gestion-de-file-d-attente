<?php
namespace App\file\Modele\DataObject;

use DateTime;

class ClientAttentes extends AbstractDataObject
{

    private ?int $idClientAttentes;
    private Ticket $idTicket;
    private Service $idService;
    private string $statut;
    private DateTime $dateArrive;

    /**
     * @param int|null $idClientAttentes
     * @param Ticket $idTicket
     * @param Service $idService
     * @param string $statut
     * @param DateTime $dateArrive
     */
    public function __construct(?int $idClientAttentes, Ticket $idTicket, Service $idService, string $statut, DateTime $dateArrive)
    {
        $this->idClientAttentes = $idClientAttentes;
        $this->idTicket = $idTicket;
        $this->idService = $idService;
        $this->statut = $statut;
        $this->dateArrive = $dateArrive;
    }



    public function getIdClientAttentes(): ?int
    {
        return $this->idClientAttentes;
    }

    public function getIdTicket(): Ticket
    {
        return $this->idTicket;
    }

    public function getIdService(): Service
    {
        return $this->idService;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }
    public function getDateArrive(): DateTime
    {
        return $this->dateArrive;
    }


}