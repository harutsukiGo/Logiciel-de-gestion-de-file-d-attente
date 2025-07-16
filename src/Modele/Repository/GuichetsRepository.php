<?php
namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\Guichets;
use App\file\Modele\DataObject\AbstractDataObject;


class GuichetsRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Guichets
    {
        return new Guichets(
            $objetFormatTableau['idGuichet'],
            $objetFormatTableau['nom_guichet'],
            $objetFormatTableau['statutGuichet'],
        );
    }


    protected function getNomTable(): string
    {
        return "guichets";
    }

    protected function getNomClePrimaire(): string
    {
        return "idGuichet";
    }

    protected function getNomsColonnes(): array
    {
    return ["idGuichet", "nom_guichet", "statutGuichet"];
    }

    protected function formatTableauSQL(AbstractDataObject $idGuichet): array
    {
        /** @var Guichets $idGuichet */
        return [
            "idGuichet" => $idGuichet->getIdGuichet(),
            "nom_guichet" => $idGuichet->getNomGuichet(),
            "statutGuichet" => $idGuichet->getStatutGuichet() ? 1 : 0,
        ];
    }

}