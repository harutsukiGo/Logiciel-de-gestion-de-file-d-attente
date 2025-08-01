<?php
namespace App\file\Controleur;

use App\file\Modele\DataObject\enumPublicite;
use App\file\Modele\DataObject\Publicite;
use App\file\Modele\Repository\PubliciteRepository;

class ControleurPublicite extends ControleurGenerique
{
   public static function recupererPublicites()
    {
        (new PubliciteRepository())->recuperer();
    }

    public static function afficherPublicitesAdministration()
    {
        ControleurGenerique::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Liste des publicités - Administration",
                "cheminCorpsVue" => "Publicite/listePublicitesAdministration.php",
                "publicites" => (new PubliciteRepository())->recupererPubOrderBy()
            ]
        );
    }


    public static function augmenterOrdre()
    {
        (new PubliciteRepository())->augmenteOrdre($_REQUEST["idPublicites"]);
    }


    public static function diminuerOrdre()
    {
        (new PubliciteRepository())->diminuerOrdre($_REQUEST["idPublicites"]);
    }


     public static function creerPubliciteAdministration()
    {
        $nomFichier = $_POST['fichier'];
        $ordre = $_POST['ordre'];
        $actif = $_POST['statut'] ? 1 : 0;
        $type = enumPublicite::from($_POST['type']);

        $publicite=new Publicite(null, $nomFichier, $ordre, $actif, $type,1);

        $publicite = (new PubliciteRepository())->ajouter($publicite);

        if (!$publicite) {
            header('Content-Type: application/json');
            echo json_encode(['failed' => false, 'message' => 'Erreur lors de la création de la publicité.']);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Publicité créée avec succès.']);
        exit;
    }

    public static function mettreAJourPubliciteAdministration(){
        $idPublicite = $_POST['idPublicites'];
        $nomFichier = $_POST['fichier'];
        $ordre = $_POST['ordre'];
        $actif = $_POST['statut'] ? 1 : 0;
        $type = enumPublicite::from($_POST['type']);

        $publicite=new Publicite($idPublicite, $nomFichier, $ordre, $actif, $type,1);

         (new PubliciteRepository())->mettreAJour($publicite);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Publicité créée avec succès.']);
        exit;
    }


    public static function supprimerPubliciteAdministration()
    {
        (new PubliciteRepository())->supprimerPublicite();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Publicité supprimée avec succès.']);
        exit;
    }
}