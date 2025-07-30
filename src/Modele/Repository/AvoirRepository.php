<?php

namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Avoir;

class AvoirRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'avoir';
    }

    protected function getNomClePrimaire(): string
    {
        return 'idAvoir';
    }

    protected function getNomsColonnes(): array
    {
        return ['idAvoir', 'idService', 'idGuichet'];
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Avoir
    {
        return new Avoir(
            $objetFormatTableau['idAvoir'] ?? null,
            $objetFormatTableau['idService'],
            $objetFormatTableau['idGuichet']
        );
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Avoir $objet */
        return [
            'idAvoirTag' => $objet->getIdAvoir(),
            'idServiceTag' => $objet->getIdService()->getIdService(),
            'idGuichetTag' => $objet->getIdGuichet()->getIdGuichet()
        ];
    }



}