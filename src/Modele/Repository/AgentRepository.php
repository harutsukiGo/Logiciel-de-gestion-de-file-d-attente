<?php
namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Agents;

class AgentRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Agents
    {
        $guichet = (new GuichetsRepository())->recupererParClePrimaire($objetFormatTableau['idGuichet']);

        return new Agents(
            $objetFormatTableau['idAgent'],
            $objetFormatTableau['nomAgent'],
            $objetFormatTableau['mailAgent'],
            $objetFormatTableau['statut'],
            $objetFormatTableau['login'],
            $objetFormatTableau['motDePasse'],
            $objetFormatTableau['role'],
            $guichet
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
            "idAgentTag" => $idAgent->getIdAgent(),
            "nomAgentTag" => $idAgent->getNomAgent(),
            "mailAgentTag" => $idAgent->getMailAgent(),
            "statutTag" => $idAgent->getStatut() ? 1 : 0,
            "loginTag" => $idAgent->getLogin(),
            "motDePasseTag" => $idAgent->getMotDePasse(),
            "roleTag" => $idAgent->getRole(),
            "idGuichetTag" => $idAgent->getIdGuichet()
        ];
    }
    public function retournePlusPetitTicketAgent(): array
    {
        $sql = "SELECT t.idTicket, t.num_ticket, s.nomService, t.statutTicket
                FROM tickets t
                JOIN client_attentes c ON c.idTicket = t.idTicket
                JOIN services s ON s.idService = c.idService
                WHERE t.statutTicket = 'en attente'
                  AND t.idAgent = :idAgentTag
                  AND t.idTicket = (
                    SELECT MIN(t2.idTicket)
                    FROM tickets t2
                    WHERE t2.statutTicket = 'en attente'
                      AND t2.idAgent = :idAgentTag);
";

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
        $sql = "SELECT * from " . $this->getNomTable() . " WHERE " ."login" . " = :loginTag";
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
        JOIN gerer g ON g.idAgent = a.idAgent
        JOIN services s ON s.idService = g.idService
        WHERE a.idAgent = :idAgentTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idAgentTag" => $idAgent
        ];
        $pdoStatement->execute($values);
        return $pdoStatement->fetchAll();
    }

}