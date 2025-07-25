<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Service;

class ServiceRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Service
    {
        return new Service(
            $objetFormatTableau['idService'],
            $objetFormatTableau['nomService'],
            new \DateTime($objetFormatTableau['horaireDebut']),
            new \DateTime($objetFormatTableau['horaireFin']),
            (bool)$objetFormatTableau['statutService']
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
        return ["idService", "nomService", "horaireDebut", "horaireFin", "statutService"];
    }

    protected function formatTableauSQL(AbstractDataObject $service): array
    {
        /** @var Service $service */
        return [
            "idService" => $service->getIdService(),
            "nomService" => $service->getNomService(),
            "horaireDebut" => $service->getHoraireDebut()->format('Y-m-d H:i:s'),
            "horaireFin" => $service->getHoraireFin()->format('Y-m-d H:i:s'),
            "statutService" => (int)$service->getStatutService()
        ];
    }

    public function getNbPersonneAttente(String $idService): int
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

}