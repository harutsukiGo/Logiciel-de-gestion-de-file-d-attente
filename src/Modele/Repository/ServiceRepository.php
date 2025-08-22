<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Service;
use DateTime;
use DateTimeZone;

class ServiceRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Service
    {
        return new Service(
            $objetFormatTableau['idService'] ?? null,
            $objetFormatTableau['nomService'],
            new \DateTime($objetFormatTableau['horaireDebut']),
            new \DateTime($objetFormatTableau['horaireFin']),
            $objetFormatTableau['statutService'],
            $objetFormatTableau['estActif']
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
        return ['idService','nomService', 'horaireDebut', 'horaireFin', 'statutService', 'estActif'];
    }

    protected function formatTableauSQL(AbstractDataObject $service): array
    {
        /** @var Service $service */
        return [
            'idServiceTag' => $service->getIdService(),
            'nomServiceTag' => $service->getNomService(),
            'horaireDebutTag' => $service->getHoraireDebut()->format('H:i:s'),
            'horaireFinTag' => $service->getHoraireFin()->format('H:i:s'),
            'statutServiceTag' => $service->getStatutService() ? 1 : 0,
            'estActifTag' => $service->getEstActif() ? 1 : 0
        ];
    }

    public function getNbPersonneAttente(int $idService): int
    {
        $sql = "SELECT COUNT(*)
            FROM client_attentes c
            JOIN services s ON s.idService = c.idService
            WHERE c.idService = :idService AND c.statut = 'en attente'";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute([':idService' => $idService]);

        return $pdoStatement->fetchColumn() ?: 0;
    }

    public function retourneNombreServices()
    {

        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $date = $date->format('H:i:s');
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE estActif = '1' AND :dateTag >= horaireDebut AND :dateTag <= horaireFin";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->execute([':dateTag'=> $date]);
         return $pdoStatement->fetchColumn();
    }


    public function recupererServices():array
    {
        $sql="SELECT * FROM ".$this->getNomTable() . " WHERE estActif='1';";
        $pdoStatement=ConnexionBaseDeDonnees::getPdo();
        $res= $pdoStatement->query($sql);
        return  $res->fetchAll();
    }


}