<?php
namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\Guichets;
use App\file\Modele\DataObject\AbstractDataObject;


class GuichetsRepository extends AbstractRepository
{
    protected function construireDepuisTableauSQL(array $objetFormatTableau): Guichets
    {
        $idService=(new ServiceRepository())->recupererParClePrimaire($objetFormatTableau["idService"]);
        return new Guichets(
            $objetFormatTableau['idGuichet'],
            $objetFormatTableau['nom_guichet'],
            $objetFormatTableau['statutGuichet'],
            $idService,
            $objetFormatTableau['estActif']
        );
    }


    protected function getNomTable(): string
    {
        return "guichets";
    }

    protected function getNomClePrimaire(): string
    {
        return "idGuichet";
    }

    protected function getNomsColonnes(): array
    {
    return ["idGuichet", "nom_guichet", "statutGuichet" ,"idService" ,"estActif"];
    }

    protected function formatTableauSQL(AbstractDataObject $idGuichet): array
    {
        /** @var Guichets $idGuichet */
        return [
            "idGuichetTag" => $idGuichet->getIdGuichet(),
            "nom_guichetTag" => $idGuichet->getNomGuichet(),
            "statutGuichetTag" => $idGuichet->getStatutGuichet() ? 1 : 0,
            "idServiceTag" => $idGuichet->getIdService()->getIdService(),
            "estActifTag" => $idGuichet->getEstActif() ? 1 : 0
        ];
    }


    public function recupererGuichets():array
    {
        $sql="SELECT idGuichet FROM ".$this->getNomTable();
        $pdoStatement=ConnexionBaseDeDonnees::getPdo();
       $res= $pdoStatement->query($sql);
       return  $res->fetchAll();
    }

    public function recupererGuichet():array
    {
        $sql="SELECT g.idGuichet, g.nom_guichet, s.nomService, a.nomAgent, g.statutGuichet, g.estActif,g.idService
              FROM guichets g
              LEFT JOIN agents a ON g.idGuichet = a.idGuichet
              LEFT JOIN services s ON s.idService = g.idService";
        $pdoStatement=ConnexionBaseDeDonnees::getPdo();
        $res= $pdoStatement->query($sql);
        return  $res->fetchAll();
    }

    public function supprimerGuichet():bool
    {
        $sql="UPDATE ". $this::getNomTable() ." SET estActif=0 WHERE idGuichet=:idGuichetTag";
        $pdoStatement=ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values= ["idGuichetTag" => $_REQUEST["idGuichet"]];
        return  $pdoStatement->execute($values);


    }
}