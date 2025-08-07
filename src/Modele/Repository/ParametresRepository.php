<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\Parametres;

class ParametresRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "parametres";
    }

    protected function getNomClePrimaire(): string
    {
        return "idParametre";
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject
    {
        return new Parametres(
            $objetFormatTableau["idParametre"],
            $objetFormatTableau["cle"],
            $objetFormatTableau["valeur"],
        );
    }

    protected function getNomsColonnes(): array
    {
        return ["idParametre", "cle", "valeur"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return [
            "idParametreTag" => $objet->getIdParametre(),
            "cleTag" => $objet->getCle(),
            "valeurTag" => $objet->getValeur(),
        ];
    }

    public function getValeur(string $cle): ?AbstractDataObject
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE cle = :cleTag";
        $res = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(":cleTag" => $cle);
        $res->execute($values);
        $objectFormatTableau = $res->fetch();

        if ($objectFormatTableau === false) {
            return null;
        }

        return $this->construireDepuisTableauSQL($objectFormatTableau);
    }

}