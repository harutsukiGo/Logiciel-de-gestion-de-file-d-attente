<?php
namespace App\file\Modele\DataObject;

class Guichets extends AbstractDataObject
{
    private ?int $idGuichet;
    private string $nomGuichet;
    private bool $statutGuichet;
    private Service $idService;
    private bool $estActif;

    public function __construct(?int $idGuichet, string $nomGuichet, bool $statutGuichet,Service $idService,bool $estActif)
    {
        $this->idGuichet = $idGuichet;
        $this->nomGuichet = $nomGuichet;
        $this->statutGuichet = $statutGuichet;
        $this->idService = $idService;
        $this->estActif = $estActif;
    }

    public function getIdGuichet(): ?int
    {
        return $this->idGuichet;
    }
    public function getNomGuichet(): string
    {
        return $this->nomGuichet;
    }
    public function getStatutGuichet(): bool
    {
        return $this->statutGuichet;
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