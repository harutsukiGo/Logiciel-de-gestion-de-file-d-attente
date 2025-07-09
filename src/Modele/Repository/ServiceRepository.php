<?php

use App\file\Modele\DataObject\AbstractDataObject;

class ServiceRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Service
    {
        return new Service(
            $objetFormatTableau['idService'],
            $objetFormatTableau['nomService'],
            new \DateTime($objetFormatTableau['horaireDebut']),
            new \DateTime($objetFormatTableau['horaireFin']),
            (bool)$objetFormatTableau['statutService']
        );
    }

    protected function getNomTable(): string
    {
        return "service";
    }

    protected function getNomClePrimaire(): string
    {
        return "idService";
    }

    protected function getNomsColonnes(): array
    {
        return ["idService", "nomService", "horaireDebut", "horaireFin", "statutService"];
    }

    protected function formatTableauSQL(AbstractDataObject $service): array
    {
        /** @var Service $service */
        return [
            "idService" => $service->getIdService(),
            "nomService" => $service->getNomService(),
            "horaireDebut" => $service->getHoraireDebut()->format('Y-m-d H:i:s'),
            "horaireFin" => $service->getHoraireFin()->format('Y-m-d H:i:s'),
            "statutService" => (int)$service->getStatutService()
        ];
    }
}