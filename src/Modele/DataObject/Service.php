<?php
namespace App\file\Modele\DataObject;

class Service extends AbstractDataObject
{
    private int $idService;
    private string $nomService;
    private \DateTime $horaireDebut;
    private \DateTime $horaireFin;
    private bool $statutService;

    public function __construct(
        int $idService,
        string $nomService,
        \DateTime $horaireDebut,
        \DateTime $horaireFin,
        bool $statutService
    ){
        $this->idService = $idService;
        $this->nomService = $nomService;
        $this->horaireDebut = $horaireDebut;
        $this->horaireFin = $horaireFin;
        $this->statutService = $statutService;
    }


    public function getIdService(): int
    {
        return $this->idService;
    }


    public function getNomService(): string
    {
        return $this->nomService;
    }


    public function getHoraireDebut(): \DateTime
    {
        return $this->horaireDebut;
    }


    public function getHoraireFin(): \DateTime
    {
        return $this->horaireFin;
    }

    public function getStatutService(): bool
    {
        return $this->statutService;
    }
}