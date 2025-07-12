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
            null
        );
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Ticket $objet */
        return [
            "idTicket" => $objet->getIdTicket(),
            "num_ticket" => $objet->getNumTicket(),
            "date_heure" => $objet->getDateHeure()->format('Y-m-d H:i:s'),
            "statutTicket" => $objet->getStatutTicket(),
            "idHistorique" => $objet->getIdHistorique()?->getIdHistorique(),
            "idAgent" => $objet->getIdAgent()?->getIdAgent()
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
        return ["idTicket", "num_ticket", "date_heure", "statutTicket", "idHistorique", "idAgent"];
    }


    public function ajouterTicket(AbstractDataObject $objet): ?AbstractDataObject
    {
        try {
            $colonnes = array_filter($this->getNomsColonnes(), function($colonne) {
                return $colonne !== 'idTicket';
            });

            $sql = "INSERT INTO " . $this->getNomTable() . " (" . implode(",", $colonnes) . ")
                VALUES (:" . implode(", :", $colonnes) . ")";

            $pdo = ConnexionBaseDeDonnees::getPdo();
            $creerObject = $pdo->prepare($sql);

            $values = $this->formatTableauSQL($objet);
            unset($values['idTicket']);

            $creerObject->execute($values);

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
}