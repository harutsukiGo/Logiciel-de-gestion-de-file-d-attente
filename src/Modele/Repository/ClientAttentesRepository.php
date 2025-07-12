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
        return ["idClientAttentes", "idTicket", "idService", "statut", "dateArrive"];
    }

    protected function formatTableauSQL(AbstractDataObject $idClientAttentes): array
    {
        /** @var ClientAttentes $idClientAttentes */
        return [
            "idClientAttentes" => $idClientAttentes->getIdClientAttentes(),
            "idTicket" => $idClientAttentes->getIdTicket()->getIdTicket(),
            "idService" => $idClientAttentes->getIdService()->getIdService(),
            "statut" => $idClientAttentes->getStatut(),
            "dateArrive" => $idClientAttentes->getDateArrive()->format('Y-m-d H:i:s')
        ];
    }


    public function ajouterClientAttentes(AbstractDataObject $objet): void
    {
        try {
            $colonnes = array_filter($this->getNomsColonnes(), function ($colonne) {
                return $colonne !== 'idClientAttentes';
            });

            $pdo = ConnexionBaseDeDonnees::getPdo();
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . implode(",", $colonnes) . ") VALUES (:" . implode(", :", $colonnes) . ")";
            $creerObject = $pdo->prepare($sql);

            $values = $this->formatTableauSQL($objet);
            unset($values['idClientAttentes']);
            $creerObject->execute($values);

        } catch (\PDOException $e) {
            throw new \Exception("Error while adding ClientAttentes: " . $e->getMessage());
        }
    }
}