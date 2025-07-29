<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Ticket;
use DateTime;
use PDOException;


class TicketRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Ticket
    {
        return new Ticket(
            $objetFormatTableau['idTicket'],
            $objetFormatTableau['num_ticket'],
            new DateTime($objetFormatTableau['date_heure']),
            $objetFormatTableau['statutTicket'],
            null,
            null,
            null,
            null
        );
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Ticket $objet */
        return [
            "num_ticketTag" => $objet->getNumTicket(),
            "date_heureTag" => $objet->getDateHeure()->format('Y-m-d H:i:s'),
            "statutTicketTag" => $objet->getStatutTicket(),
            "idHistoriqueTag" => $objet->getIdHistorique()?->getIdHistorique(),
            "idAgentTag" => $objet->getIdAgent()?->getIdAgent(),
            "date_arriveeTag" => $objet->getDateArrivee()?->format('Y-m-d H:i:s'),
            "date_termineeTag" => $objet->getDateTerminee()?->format('Y-m-d H:i:s')
        ];
    }

    protected function getNomTable(): string
    {
        return "tickets";
    }

    protected function getNomClePrimaire(): string
    {
        return "idTicket";
    }


    protected function getNomsColonnes(): array
    {
        return ["num_ticket", "date_heure", "statutTicket", "idHistorique", "idAgent", "date_arrivee", "date_terminee"];
    }


    public function ajouterTicket(AbstractDataObject $objet): ?AbstractDataObject
    {
        try {
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . join(",", $this->getNomsColonnes()) . ") VALUES (:" . join("Tag, :", $this->getNomsColonnes()) . "Tag)";
            $creerObject = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $creerObject->execute($this->formatTableauSQL($objet));
            $pdo = ConnexionBaseDeDonnees::getPdo();
            $dernierID = $pdo->lastInsertId();
            return $this->recupererParClePrimaire($dernierID);
        } catch (PDOException $e) {
            return null;
        }
    }


    public function mettreAJourHistorique(AbstractDataObject $historique, AbstractDataObject $ticket): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET idHistorique = :idHistoriqueTag WHERE idTicket = :idTicketTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idHistoriqueTag" => $historique->getIdHistorique(),
            "idTicketTag" => $ticket->getIdTicket()
        ];
        $pdoStatement->execute($values);
    }

    public function compteTicket()
    {
        $sql = "SELECT COUNT(*)  FROM " . $this->getNomTable() ." WHERE date(date_heure)=date(now());";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);
        return $pdoStatement->fetch()[0];
    }


    public function recupererTickets(): array
    {
        $sql = "SELECT t.idTicket, t.num_ticket, g.nom_guichet, s.nomService, t.statutTicket
            FROM tickets t 
             JOIN client_attentes c ON c.idTicket = t.idTicket
             JOIN services s ON s.idService = c.idService
             JOIN avoir a ON a.idService = s.idService
             JOIN guichets g ON g.idGuichet = a.idGuichet
            WHERE t.statutTicket = 'en attente'
          ";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);
        return $pdoStatement->fetchAll();
    }

    public function retournePlusPetitTicket(): array
    {
        $sql = "SELECT t.idTicket,t.num_ticket, g.nom_guichet, s.nomService
            FROM tickets t
            JOIN client_attentes c ON c.idTicket = t.idTicket
            JOIN services s ON s.idService = c.idService
            JOIN avoir a ON a.idService = s.idService
            JOIN guichets g ON g.idGuichet = a.idGuichet
            WHERE t.statutTicket = 'en attente' 
            AND t.idTicket = (
                SELECT MIN(t2.idTicket)
                FROM tickets t2
                WHERE t2.statutTicket = 'en attente'
            )";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);

        return $pdoStatement->fetchAll();
    }

    public function mettreAJourStatut(int $idTicket, string $staut): bool
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET statutTicket = :statutTag WHERE idTicket = :idTicketTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = [
                "statutTag" => "$staut",
                "idTicketTag" => $idTicket
            ];
            return $pdoStatement->execute($values);
        } catch (PDOException $e) {
            return false;
        }

    }

    public function recupererNbTicketsEnAttente(): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE statutTicket = 'en attente'";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);
        return (int)$pdoStatement->fetchColumn();
    }

    public function mettreAJourDateArrivee(int $idTicket, DateTime $date): bool
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET date_arrivee = :date_arriveeTag WHERE idTicket = :idTicketTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = [
                "date_arriveeTag" => $date->format('Y-m-d H:i:s'),
                "idTicketTag" => $idTicket
            ];
            return $pdoStatement->execute($values);
        } catch (PDOException $e) {
            return false;
        }

    }

    public function mettreAJourDateTerminee(int $idTicket, DateTime $date): bool
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET date_terminee = :date_termineeTag WHERE idTicket = :idTicketTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = [
                "date_termineeTag" => $date->format('Y-m-d H:i:s'),
                "idTicketTag" => $idTicket
            ];
            return $pdoStatement->execute($values);
        } catch (PDOException $e) {
            return false;
        }

    }

    public function getTempsAttenteMoyen(): string
    {
        $sql = "SELECT ROUND(AVG(TIMESTAMPDIFF(MINUTE, date_arrivee, date_terminee))) AS temps_moyen
            FROM  tickets t
            WHERE statutTicket = 'terminé'";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);
        $resultat = $pdoStatement->fetchColumn();

        return $resultat ? $resultat . " min" : "0 min";
    }

    public function compterNombreClient($idAgent): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE idAgent =:idAgentTag AND date(date_heure)=date(now())";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute(['idAgentTag' => $idAgent]);
        return $pdoStatement->fetch()[0];
    }

    public function nbTicketParService($idService): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " t
            JOIN client_attentes c ON c.idTicket = t.idTicket
            WHERE c.idService = :idServiceTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute(['idServiceTag' => $idService]);
        return (int)$pdoStatement->fetchColumn();
    }


}