<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\ClientAttentes;
use App\file\Modele\DataObject\AbstractDataObject;

class ClientAttentesRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): ClientAttentes
    {
        return new ClientAttentes(
            $objetFormatTableau['idClientAttentes'],
            (new TicketRepository())->recupererParClePrimaire($objetFormatTableau['idTicket']),
            (new ServiceRepository())->recupererParClePrimaire($objetFormatTableau['idService']),
            $objetFormatTableau['statut'],
            new \DateTime($objetFormatTableau['dateArrive'])
        );
    }


    protected function getNomTable(): string
    {
        return "client_attentes";
    }

    protected function getNomClePrimaire(): string
    {
        return "idClientAttentes";
    }

    protected function getNomsColonnes(): array
    {
        return ["idTicket", "idService", "statut", "dateArrive"];
    }

    protected function formatTableauSQL(AbstractDataObject $idClientAttentes): array
    {
        /** @var ClientAttentes $idClientAttentes */
        return [
            "idTicketTag" => $idClientAttentes->getIdTicket()->getIdTicket(),
            "idServiceTag" => $idClientAttentes->getIdService()->getIdService(),
            "statutTag" => $idClientAttentes->getStatut(),
            "dateArriveTag" => $idClientAttentes->getDateArrive()->format('Y-m-d H:i:s')
        ];
    }


    public function ajouterClientAttentes(AbstractDataObject $objet):void
    {
        try {
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . join(",", $this->getNomsColonnes()) . ") VALUES (:" . join("Tag, :", $this->getNomsColonnes()) . "Tag)";
            $creerObject = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $creerObject->execute($this->formatTableauSQL($objet));
        } catch (PDOException $e) {
            return;
        }
    }


    public function mettreAJourService($idTicket, $idService): void
    {
        try {
            $pdo = ConnexionBaseDeDonnees::getPdo();
            $sql = "UPDATE " . $this->getNomTable() . " SET idService = :idService WHERE idTicket = :idTicket";
            $resultat = $pdo->prepare($sql);
            $resultat->execute(['idService' => $idService, 'idTicket' => $idTicket]);
        } catch (\PDOException $e) {
            throw new \Exception("Error while updating service: " . $e->getMessage());
        }
    }

}