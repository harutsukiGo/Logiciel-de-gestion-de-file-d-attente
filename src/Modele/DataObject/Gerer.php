<?php
namespace App\file\Modele\DataObject;

class Gerer extends AbstractDataObject
{
    private ?int $idGerer;
    private Service $idService;
    private Agents $idAgent;

    public function __construct(?int $idGerer, Service $idService, Agents $idAgent)
    {
        $this->idGerer = $idGerer;
        $this->idService = $idService;
        $this->idAgent = $idAgent;
    }

    public function getIdGerer(): ?int
    {
        return $this->idGerer;
    }
    public function getIdService(): Service
    {
        return $this->idService;
    }
    public function getIdAgent(): Agents
    {
        return $this->idAgent;
    }
}