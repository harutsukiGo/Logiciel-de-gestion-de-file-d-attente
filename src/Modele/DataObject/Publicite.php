<?php
namespace App\file\Modele\DataObject;

class Publicite extends AbstractDataObject
{
private ?int $idPublicites;
private string $fichier;
private int $ordre;
private bool $actif;
private enumPublicite $type;


    public function __construct(?int $idPublicites, string $fichier, int $ordre, bool $actif, enumPublicite $type)
    {
        $this->idPublicites = $idPublicites;
        $this->fichier = $fichier;
        $this->ordre = $ordre;
        $this->actif = $actif;
        $this->type = $type;
    }

    public function getIdPublicite(): ?int
    {
        return $this->idPublicites;
    }

    public function getFichier(): string
    {
        return $this->fichier;
    }

    public function getOrdre(): int
    {
        return $this->ordre;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function getType(): enumPublicite
    {
        return $this->type;
    }




}