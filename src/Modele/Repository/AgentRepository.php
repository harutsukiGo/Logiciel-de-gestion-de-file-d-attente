<?php

namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\Repository\GuichetsRepository;
use App\file\Modele\DataObject\Agents;

class AgentRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Agents
    {
        // Créer d'abord l'objet Guichets
        $guichet = (new GuichetsRepository())->recupererParClePrimaire($objetFormatTableau['idGuichet']);

        return new Agents(
            $objetFormatTableau['idAgent'],
            $objetFormatTableau['nomAgent'],
            $objetFormatTableau['mailAgent'],
            $objetFormatTableau['statut'],
            $objetFormatTableau['login'],
            $objetFormatTableau['motDePasse'],
            $objetFormatTableau['role'],
            $guichet  // Passer l'objet Guichets au lieu de l'ID
        );
    }


    protected function getNomTable(): string
    {
        return "agents";
    }

    protected function getNomClePrimaire(): string
    {
        return "idAgent";
    }

    protected function getNomsColonnes(): array
    {
        return ["idAgent", "nomAgent", "mailAgent", "statut", "login", "motDePasse", "role", "idGuichet"];
    }

    protected function formatTableauSQL(AbstractDataObject $idAgent): array
    {
        /** @var Agents $idAgent */
        return [
            "idAgent" => $idAgent->getIdAgent(),
            "nomAgent" => $idAgent->getNomAgent(),
            "mailAgent" => $idAgent->getMailAgent(),
            "statut" => $idAgent->getStatut() ? 1 : 0,
            "login" => $idAgent->getLogin(),
            "motDePasse" => $idAgent->getMotDePasse(),
            "role" => $idAgent->getRole(),
            "idGuichet" => $idAgent->getIdGuichet()
        ];
    }



}