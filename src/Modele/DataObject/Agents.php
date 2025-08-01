<?php

namespace App\file\Modele\DataObject;

class Agents extends AbstractDataObject
{
    private ?int $idAgent;
    private string $nomAgent;
    private string $mailAgent;
    private bool $statut;
    private string $login;
    private string $motDePasse;
    private string $role;
    private Guichets $idGuichet;
    private Service $idService;
    private bool $estActif;


    public function __construct(?int $idAgent, string $nomAgent, string $mailAgent, bool $statut, string $login, string $motDePasse, string $role, Guichets $idGuichet,Service $idService ,bool $estActif)
    {
        $this->idAgent = $idAgent;
        $this->nomAgent = $nomAgent;
        $this->mailAgent = $mailAgent;
        $this->statut = $statut;
        $this->login = $login;
        $this->motDePasse = $motDePasse;
        $this->role = $role;
        $this->idGuichet = $idGuichet;
        $this->idService = $idService;
        $this->estActif = $estActif;
    }

    public function getIdAgent(): ?int
    {
        return $this->idAgent;
    }

    public function getNomAgent(): string
    {
        return $this->nomAgent;
    }

    public function getMailAgent(): string
    {
        return $this->mailAgent;
    }

    public function getStatut(): bool
    {
        return $this->statut;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function getRole(): string
    {
        return $this->role;
    }
    public function getIdGuichet(): Guichets
    {
        return $this->idGuichet;
    }

    public function getEstActif(): bool
    {
        return $this->estActif;
    }

    public function getIdService(): Service
    {
        return $this->idService;
    }
}