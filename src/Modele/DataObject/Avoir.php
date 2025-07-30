<?php
namespace App\file\Modele\DataObject;

class Avoir extends AbstractDataObject
{
    private ?int $idAvoir;
    private Service $idService;
    private Guichets $idGuichet;

    public function __construct(?int $idAvoir, Service $idService, Guichets $idGuichet)
    {
        $this->idAvoir = $idAvoir;
        $this->idService = $idService;
        $this->idGuichet = $idGuichet;
    }
    public function getIdAvoir(): ?int
    {
        return $this->idAvoir;
    }
    public function getIdService(): Service
    {
        return $this->idService;
    }
    public function getIdGuichet(): Guichets
    {
        return $this->idGuichet;
    }
 }