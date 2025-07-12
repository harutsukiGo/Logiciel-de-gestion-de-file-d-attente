<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Historique;
use PDOException;

class HistoriqueRepository extends AbstractRepository
{

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Historique
    {
        $ticketRepository = new TicketRepository();
        $agentRepository = new AgentRepository();
        return new Historique(
            $objetFormatTableau['idHistorique'],
            $objetFormatTableau['statut'],
            new \DateTime($objetFormatTableau['date_heure']),
            $objetFormatTableau['action'],
            $ticketRepository->recupererParClePrimaire($objetFormatTableau['idTicket']), // Get Ticket object
            $agentRepository->recupererParClePrimaire($objetFormatTableau['idAgent'])    // Get Agent object
        );
    }


    protected function getNomTable(): string
    {
        return "historique";
    }

    protected function getNomClePrimaire(): string
    {
        return "idHistorique";
    }

    protected function getNomsColonnes(): array
    {
        return ["idHistorique", "statut", "date_heure", "action", "idTicket", "idAgent"];
    }

    protected function formatTableauSQL(AbstractDataObject $idHistorique): array
    {

        /** @var Historique $idHistorique */
        return [
            "idHistorique" => $idHistorique->getIdHistorique(),
            "statut" => $idHistorique->getStatut(),
            "date_heure" => $idHistorique->getDateHeure()->format('Y-m-d H:i:s'),
            "action" => $idHistorique->getAction(),
            "idTicket" => $idHistorique->getIdTicket()->getIdTicket(),
            "idAgent" => $idHistorique->getIdAgent()->getIdAgent()
        ];
    }

    public function ajouterHistorique(AbstractDataObject $objet): ?AbstractDataObject
    {
        try {
            $colonnes = array_filter($this->getNomsColonnes(), function ($colonne) {
                return $colonne !== 'idHistorique';
            });
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . join(",", $colonnes) . ") VALUES (:" . join(", :", $colonnes) . ")";
            $pdo = ConnexionBaseDeDonnees::getPdo();
            $creerObject = $pdo->prepare($sql);

            $values = $this->formatTableauSQL($objet);
            unset($values['idHistorique']);

            $creerObject->execute($values);

            $dernierID = $pdo->lastInsertId();

            return $this->recupererParClePrimaire($dernierID);

        } catch (PDOException $e) {
            return null;
        }
    }


}