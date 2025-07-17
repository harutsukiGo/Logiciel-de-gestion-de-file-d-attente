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

        $typeEnum = match($objetFormatTableau['type']) {
            'image' => enumPublicite::image,
            'video' => enumPublicite::video,
        };
        return new Publicite(
            $objetFormatTableau['idPublicites'],
            $objetFormatTableau['fichier'],
            $objetFormatTableau['ordre'],
            $objetFormatTableau['actif'],
           $typeEnum
        );
    }

    protected function getNomsColonnes(): array
    {
        return ["idPublicites", "fichier", "ordre", "actif", "type"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Publicite $objet */
        return [
            "idPublicites" => $objet->getIdPublicite(),
            "fichier" => $objet->getFichier(),
            "ordre" => $objet->getOrdre(),
            "actif" => $objet->isActif() ? 1 : 0,
            "type" => $objet->getType()
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

}