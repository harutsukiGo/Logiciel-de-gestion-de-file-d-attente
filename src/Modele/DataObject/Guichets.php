<?php
namespace App\file\Modele\DataObject;

class Guichets extends AbstractDataObject
{
    private int $idGuichet;
    private string $nomGuichet;
    private bool $statutGuichet;

    public function __construct(int $idGuichet, string $nomGuichet, bool $statutGuichet)
    {
        $this->idGuichet = $idGuichet;
        $this->nomGuichet = $nomGuichet;
        $this->statutGuichet = $statutGuichet;
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

}