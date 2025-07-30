<?php
namespace file\Modele\DataObject;

use App\file\Modele\DataObject\Gerer;
use App\file\Modele\Repository\AbstractRepository;
use App\file\Modele\DataObject\AbstractDataObject;

class GererRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Gerer
    {
        $service = (new ServiceRepository())->recupererParClePrimaire($objetFormatTableau['idService']);
        $agent = (new AgentRepository())->recupererParClePrimaire($objetFormatTableau['idAgent']);
        return new Gerer(
            $objetFormatTableau['idGerer'],
            $service,
            $agent
        );
    }

    protected function getNomTable(): string
    {
        return "gerer";
    }

    protected function getNomClePrimaire(): string
    {
        return "idGerer";
    }

    protected function getNomsColonnes(): array
    {
        return ["idGerer", "idService", "idAgent"];
    }

    protected function formatTableauSQL(AbstractDataObject $gerer): array
    {
        /** @var Gerer $gerer */
        return [
            "idGererTag" => $gerer->getIdGerer(),
            "idServiceTag" => $gerer->getIdService()->getIdService(),
            "idAgentTag" => $gerer->getIdAgent()->getIdAgent()
        ];
    }
}