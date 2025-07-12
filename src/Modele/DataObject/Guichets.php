<?php
namespace App\file\Modele\DataObject;

class Guichets extends AbstractDataObject
{
    private int $idGuichet;
    private string $nomGuichet;
    private bool $statutGuichet;
    private Service $idService;

    public function __construct(int $idGuichet, string $nomGuichet, bool $statutGuichet, Service $idService)
    {
        $this->idGuichet = $idGuichet;
        $this->nomGuichet = $nomGuichet;
        $this->statutGuichet = $statutGuichet;
        $this->idService = $idService;
    }

    public function getIdGuichet(): int
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
    public function getIdService(): Service
    {
        return $this->idService;
    }

}