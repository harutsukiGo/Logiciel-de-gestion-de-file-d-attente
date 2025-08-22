<?php

namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Agents;

class AgentRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Agents
    {
        $guichet = (new GuichetsRepository())->recupererParClePrimaire($objetFormatTableau['idGuichet']);
        $service = (new ServiceRepository())->recupererParClePrimaire($objetFormatTableau['idService']);

        return new Agents(
            $objetFormatTableau['idAgent'],
            $objetFormatTableau['nomAgent'],
            $objetFormatTableau['mailAgent'],
            $objetFormatTableau['statut'],
            $objetFormatTableau['login'],
            $objetFormatTableau['motDePasse'],
            $objetFormatTableau['role'],
            $guichet,
            $service,
            $objetFormatTableau['estActif']
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
        return ["idAgent", "nomAgent", "mailAgent", "statut", "login", "motDePasse", "role", "idService", "idGuichet", "estActif"];
    }

    protected function formatTableauSQL(AbstractDataObject $idAgent): array
    {
        /** @var Agents $idAgent */
        return [
            "idAgentTag" => $idAgent->getIdAgent(),
            "nomAgentTag" => $idAgent->getNomAgent(),
            "mailAgentTag" => $idAgent->getMailAgent(),
            "statutTag" => $idAgent->getStatut() ? 1 : 0,
            "loginTag" => $idAgent->getLogin(),
            "motDePasseTag" => $idAgent->getMotDePasse(),
            "roleTag" => $idAgent->getRole(),
            "idGuichetTag" => $idAgent->getIdGuichet()->getIdGuichet(),
            "idServiceTag" => $idAgent->getIdService()->getIdService(),
            "estActifTag" => $idAgent->getEstActif() ? 1 : 0
        ];
    }

    public function retournePlusPetitTicketAgent(): array
    {
        $sql = "SELECT t.idTicket, t.num_ticket, s.nomService, t.statutTicket,t.idHistorique
                FROM tickets t
                JOIN client_attentes c ON c.idTicket = t.idTicket
                JOIN services s ON s.idService = c.idService
                WHERE t.statutTicket = 'en attente'
                  AND t.idAgent = :idAgentTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idAgentTag" => $_REQUEST['idAgent']
        ];

        $pdoStatement->execute($values);
        return $pdoStatement->fetchAll();
    }

    public function mettreAJourStatut(int $idAgent, string $statut): bool
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET statut = :statutTag WHERE idAgent = :idAgentTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = [
                "statutTag" => "$statut",
                "idAgentTag" => $idAgent
            ];
            return $pdoStatement->execute($values);
        } catch (PDOException $e) {
            return false;
        }

    }


    public function afficherFileAttente($idAgent): array
    {
        $sql = "SELECT t.idTicket, num_ticket, s.nomService 
            FROM tickets t
            JOIN client_attentes c ON t.idTicket = c.idTicket
            JOIN services s ON c.idService = s.idService
            WHERE t.statutTicket = 'en attente' AND t.idAgent = :idAgentTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idAgentTag" => $idAgent
        ];
        $pdoStatement->execute($values);
        return $pdoStatement->fetchAll();

    }

    public function recupererParLogin(string $login): ?AbstractDataObject
    {
        $sql = "SELECT * from " . $this->getNomTable() . " WHERE " . "login" . " = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $login,
        );
        $pdoStatement->execute($values);

        $objectFormatTableau = $pdoStatement->fetch();

        if (!$objectFormatTableau) {
            return null;
        } else {
            return $this->construireDepuisTableauSQL($objectFormatTableau);
        }
    }

    public function recupererServicesParAgent($idAgent): array
    {
        $sql = "SELECT s.nomService
        FROM " . $this->getNomTable() . " a
        JOIN services s ON s.idService = a.idService
        WHERE a.idAgent = :idAgentTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idAgentTag" => $idAgent
        ];
        $pdoStatement->execute($values);
        return $pdoStatement->fetchAll();
    }

    public function recupererAgentActif()
    {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query("SELECT * FROM " . $this->getNomTable()." WHERE estActif = '1'");

        $objects = [];
        foreach ($pdoStatement as $object) {
            $objects[] = $this->construireDepuisTableauSQL($object);
        }
        return $objects;
    }

    public function retourneAgentPourUnService(int $idService):int
    {
        $sql = "SELECT idAgent FROM " . $this->getNomTable() . " WHERE idService = :idService";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idService" => $idService
        ];
        $pdoStatement->execute($values);
        return $pdoStatement->fetchColumn();
    }

    public function retourneNbAgentParService(int $idService):int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE idService = :idService";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idService" => $idService
        ];
        $pdoStatement->execute($values);
        return $pdoStatement->fetchColumn();
    }
}