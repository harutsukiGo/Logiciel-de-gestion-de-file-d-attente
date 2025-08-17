<?php

namespace App\file\Modele\Repository;

use App\file\Modele\DataObject\AbstractDataObject;
use App\file\Modele\DataObject\enumPublicite;
use App\file\Modele\DataObject\Publicite;

class PubliciteRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "publicites";
    }

    protected function getNomClePrimaire(): string
    {
        return "idPublicites";
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject
    {

        $typeEnum = match ($objetFormatTableau['type']) {
            'image' =>  enumPublicite::from('image'),
            'vidéo' =>  enumPublicite::from('vidéo'),
        };
        return new Publicite(
            $objetFormatTableau['idPublicites'],
            $objetFormatTableau['fichier'],
            $objetFormatTableau['ordre'],
            $objetFormatTableau['actif'],
            $typeEnum,
            $objetFormatTableau['estActif'],
        );
    }

    protected function getNomsColonnes(): array
    {
        return ["idPublicites", "fichier", "ordre", "actif", "type", "estActif"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Publicite $objet */
        return [
            "idPublicitesTag" => $objet->getIdPublicite(),
            "fichierTag" => $objet->getFichier(),
            "ordreTag" => $objet->getOrdre(),
            "actifTag" => $objet->getActif() ? 1 : 0,
            "typeTag" => $objet->getType()->getValue(),
            "estActifTag" => $objet->getEstActif() ? 1 : 0,
        ];
    }

    public function recupererPublicitesActives(): array
    {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare("SELECT * FROM " . $this->getNomTable() . " WHERE actif = 1 ORDER BY ordre ASC");
        $pdoStatement->execute();

        $publicites = [];
        foreach ($pdoStatement as $publicite) {
            $publicites[] = $this->construireDepuisTableauSQL($publicite);
        }
        return $publicites;
    }

    public function augmenteOrdre($idPublicites)
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET ordre = ordre +1 WHERE idPublicites=:idPublicites";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values=["idPublicites"=>$idPublicites];
         $pdoStatement->execute($values);
        return (new PubliciteRepository())->recupererParClePrimaire($idPublicites);
    }

    public function diminuerOrdre($idPublicites)
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET ordre = ordre -1 WHERE idPublicites=:idPublicites";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values=["idPublicites"=>$idPublicites];
         $pdoStatement->execute($values);
        return (new PubliciteRepository())->recupererParClePrimaire($idPublicites);
    }

    public function recupererPubOrderBy(): array
    {

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query("SELECT * FROM " . $this->getNomTable() ." ORDER BY ordre ASC");

        $objects = [];
        foreach ($pdoStatement as $object) {
            $objects[] = $this->construireDepuisTableauSQL($object);
        }
        return $objects;
    }

    public function supprimerPublicite(): bool
    {
        $sql='UPDATE ' . $this->getNomTable() . ' SET estActif = 0 WHERE idPublicites = :idPublicitesTag';
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = [
            "idPublicitesTag" => $_REQUEST['idPublicites']
        ];
        return $pdoStatement->execute($values);
    }
}