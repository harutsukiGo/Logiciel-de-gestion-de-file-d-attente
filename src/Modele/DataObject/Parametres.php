<?php
namespace App\Modele\DataObject;

use App\file\Modele\DataObject\AbstractDataObject;

class Parametres extends AbstractDataObject{

    private ?int $idParametre;

    private string $cle;

    private string $valeur;


    public function __construct(?int $idParametre, string $cle, string $valeur)
    {
        $this->idParametre = $idParametre;
        $this->cle = $cle;
        $this->valeur = $valeur;
    }

    public function getIdParametre(): ?int
    {
        return $this->idParametre;
    }

    public function getCle(): string
    {
        return $this->cle;
    }

    public function getValeur(): string
    {
        return $this->valeur;
    }



}