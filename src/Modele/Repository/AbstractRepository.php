<?php

namespace App\file\Modele\Repository;
use App\file\Modele\DataObject\AbstractDataObject;
use PDOException;


abstract class AbstractRepository
{
    public function mettreAJour(AbstractDataObject $objet): void
    {

        $sql = "UPDATE " . $this->getNomTable() . " SET ";
        $colonnes = $this->getNomsColonnes();

        for ($i = 0; $i < sizeof($colonnes); $i++) {
            if ($i == sizeof($colonnes) - 1) {
                $sql .= $colonnes[$i] . "= :" . $colonnes[$i] . "Tag ";
            } else {
                $sql .= $colonnes[$i] . "= :" . $colonnes[$i] . "Tag, ";
            }
        }

        $sql .= " WHERE " . $this->getNomClePrimaire() . " = :" . $this->getNomClePrimaire() . "Tag;";

        $creerObjet = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $creerObjet->execute($this->formatTableauSQL($objet));


    }

    public function ajouter(AbstractDataObject $objet): bool
    {
        try {
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . join(",", $this->getNomsColonnes()) . ") VALUES (:" . join("Tag, :", $this->getNomsColonnes()) . "Tag)";
            $creerObject = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $creerObject->execute($this->formatTableauSQL($objet));
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public function ajouterAutoIncrement(AbstractDataObject $objet): ?AbstractDataObject
    {
        try {
            $sql = "INSERT INTO " . $this->getNomTable() . " (" . join(",", $this->getNomsColonnes()) . ") VALUES (:" . join("Tag, :", $this->getNomsColonnes()) . "Tag)";
            $creerObject = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $creerObject->execute($this->formatTableauSQL($objet));
            $pdo = ConnexionBaseDeDonnees::getPdo();
            $dernierID = $pdo->lastInsertId();
            return $this->recupererParClePrimaire($dernierID);
        } catch (PDOException $e) {
            return null;
        }
    }




    public function supprimer(string $valeurClePrimaire): bool
    {
        try {
            $creerutilisateur = ConnexionBaseDeDonnees::getPdo()->prepare("DELETE FROM " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . " = :cleTag");
            $values = array(
                "cleTag" => $valeurClePrimaire
            );
            $creerutilisateur->execute($values);
        } catch (PDOException) {
            return false;
        }
        return true;
    }

    public function recupererParClePrimaire(string $cle): ?AbstractDataObject
    {
        $sql = "SELECT * from " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . " = :cleTag";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "cleTag" => $cle,
        );
        $pdoStatement->execute($values);

        $objectFormatTableau = $pdoStatement->fetch();

        if (!$objectFormatTableau) {
            return null;
        } else {
            return $this->construireDepuisTableauSQL($objectFormatTableau);
        }
    }

    /**
     * @return AbstractDataObject[]
     */
    public function recuperer(): array
    {

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query("SELECT * FROM " . $this->getNomTable());

        $objects = [];
        foreach ($pdoStatement as $object) {
             $objects[] = $this->construireDepuisTableauSQL($object);
        }
          return $objects;
    }

    protected abstract function getNomTable(): string;

    protected abstract function getNomClePrimaire(): string;

    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject;

    /** @return string[] */
    protected abstract function getNomsColonnes(): array;

    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;

}