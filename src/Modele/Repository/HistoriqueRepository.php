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
            $ticketRepository->recupererParClePrimaire($objetFormatTableau['idTicket']),
            $agentRepository->recupererParClePrimaire($objetFormatTableau['idAgent'])
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
        return ["statut", "date_heure", "action", "idTicket", "idAgent"];
    }

    protected function formatTableauSQL(AbstractDataObject $idHistorique): array
    {

        /** @var Historique $idHistorique */
        return [
            "statutTag" => $idHistorique->getStatut(),
            "date_heureTag" => $idHistorique->getDateHeure()->format('Y-m-d H:i:s'),
            "actionTag" => $idHistorique->getAction(),
            "idTicketTag" => $idHistorique->getIdTicket()->getIdTicket(),
            "idAgentTag" => $idHistorique->getIdAgent()->getIdAgent()
        ];
    }

    public function recupererHistoriqueParAgent($idAgent): array
    {
        $sql = "SELECT num_ticket, nomService, historique.date_heure  
                FROM " . $this->getNomTable() .
                " JOIN tickets t ON t.idTicket = historique.idTicket " .
                " JOIN client_attentes c ON t.idTicket = c.idTicket " .
                " JOIN services s ON c.idService = s.idService " .
                "WHERE t.idAgent = :idAgentTag LIMIT 3";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idAgentTag" => $idAgent
        ];

        $pdoStatement->execute($values);
        return $pdoStatement->fetchAll();
    }

    public function mettreAJourStatutHistorique(int $idHistorique, string $statut): bool
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET statut = :statutTag WHERE idHistorique = :idHistoriqueTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = ["statutTag" => $statut, "idHistoriqueTag" => $idHistorique];
            return $pdoStatement->execute($values);
        } catch (PDOException $e) {
            return false;
        }

    }

}