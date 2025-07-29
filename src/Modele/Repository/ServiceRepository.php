<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Service;

class ServiceRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Service
    {
        return new Service(
            $objetFormatTableau['idService'] ?? null,
            $objetFormatTableau['nomService'],
            new \DateTime($objetFormatTableau['horaireDebut']),
            new \DateTime($objetFormatTableau['horaireFin']),
            $objetFormatTableau['statutService']
        );
    }

    protected function getNomTable(): string
    {
        return "services";
    }

    protected function getNomClePrimaire(): string
    {
        return "idService";
    }

    protected function getNomsColonnes(): array
    {
        return ['idService','nomService', 'horaireDebut', 'horaireFin', 'statutService'];
    }

    protected function formatTableauSQL(AbstractDataObject $service): array
    {
        /** @var Service $service */
        return [
            'idServiceTag' => $service->getIdService(),
            'nomServiceTag' => $service->getNomService(),
            'horaireDebutTag' => $service->getHoraireDebut()->format('H:i:s'),
            'horaireFinTag' => $service->getHoraireFin()->format('H:i:s'),
            'statutServiceTag' => $service->getStatutService() ? 1 : 0
        ];
    }

    public function getNbPersonneAttente(string $idService): int
    {
        $sql = "SELECT COUNT(*)
            FROM client_attentes c
            JOIN services s ON s.idService = c.idService
            WHERE c.idService = :idService";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute([':idService' => $idService]);

        return $pdoStatement->fetchColumn() ?: 0;
    }

    public function getNomService(int $idService): ?string
    {
        $sql = "SELECT nomService FROM " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . " = :idServiceTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->bindValue(':idServiceTag', $idService);
        $pdoStatement->execute();

        return $pdoStatement->fetchColumn() ?: null;
    }

    public function retourneNombreServices()
    {
        $sql = "SELECT COUNT(*)  FROM " . $this->getNomTable();
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);
        return $pdoStatement->fetch()[0];
    }

    public function ajouterService(AbstractDataObject $objet): ?AbstractDataObject
    {
        try {
            $colonnes = array_filter($this->getNomsColonnes(), function ($colonne) {
                return $colonne !== 'idService';
            });

            $sql = "INSERT INTO " . $this->getNomTable() . " (" . implode(",", $colonnes) . ")
                VALUES (:" . implode(", :", $colonnes) . ")";

            $pdo = ConnexionBaseDeDonnees::getPdo();
            $creerObject = $pdo->prepare($sql);

            $values = $this->formatTableauSQL($objet);
            unset($values['idService']);

            $creerObject->execute($values);

            $dernierID = $pdo->lastInsertId();

            return $this->recupererParClePrimaire($dernierID);
        } catch (PDOException $e) {
            return null;
        }
    }
}