<?php
namespace App\file\Controleur;

use App\file\Configuration\Publicite\PusherPublicite;
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
       $publicite= (new PubliciteRepository())->augmenteOrdre($_REQUEST["idPublicites"]);
        $pusher = new PusherPublicite();
         $pusher->trigger('publicite-channel','publicite-augmente',[
            'idPublicite' => $_REQUEST['idPublicites'],
             'ordre'=>$publicite->getOrdre()]);
    }


    public static function diminuerOrdre()
    {
        $publicite=(new PubliciteRepository())->diminuerOrdre($_REQUEST["idPublicites"]);
        $pusher = new PusherPublicite();
        $pusher->trigger('publicite-channel','publicite-diminue',[
            'idPublicite' => $_REQUEST['idPublicites'],
            'ordre'=>$publicite->getOrdre()]);
    }


     public static function creerPubliciteAdministration()
    {
        $nomFichier = $_POST['fichier'];
        $ordre = $_POST['ordre'];
        $actif = $_POST['actif'] ? 1 : 0;
        $type = enumPublicite::from($_POST['type']);

        $publicite=new Publicite(null, $nomFichier, $ordre, $actif, $type,1);

        $publicite = (new PubliciteRepository())->ajouterAutoIncrement($publicite);

        if (!$publicite) {
            header('Content-Type: application/json');
            echo json_encode(['failed' => false, 'message' => 'Erreur lors de la création de la publicité.']);
            exit;
        }

        $pusher = new PusherPublicite();
        $pusher->trigger('publicite-channel','publicite-cree',[
            'idPublicite' => $publicite->getIdPublicite(),
            'nomFichier'=>$publicite->getFichier(),
            'ordre' => $publicite->getOrdre(),
            'actif' => $publicite->getActif(),
            'type' => $type->getValue()
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Publicité créée avec succès.']);
        exit;
    }

    public static function mettreAJourPubliciteAdministration(){
        $idPublicite = $_POST['idPublicites'];
        $nomFichier = $_POST['fichier'];
        $ordre = $_POST['ordre'];
        $actif = $_POST['actif'] ? 1 : 0;
        $type = enumPublicite::from($_POST['type']);

        $publicite=new Publicite($idPublicite, $nomFichier, $ordre, $actif, $type,1);

         (new PubliciteRepository())->mettreAJour($publicite);

        $pusher = new PusherPublicite();
        $pusher->trigger('publicite-channel','publicite-modifiee',[
            'idPublicite' => $publicite->getIdPublicite(),
            'nomFichier'=>$publicite->getFichier(),
            'ordre' => $publicite->getOrdre(),
            'actif' => $publicite->getActif(),
            'type' => $type->getValue()
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Publicité créée avec succès.']);
        exit;
    }


    public static function supprimerPubliciteAdministration()
    {
        (new PubliciteRepository())->supprimer($_REQUEST['idPublicites']);

        $pusher = new PusherPublicite();
        header('Content-Type: application/json');
        $pusher->trigger('publicite-channel','publicite-supprime',[
            'idPublicite' => $_REQUEST['idPublicites']]);
        echo json_encode(['success' => true, 'message' => 'Publicité supprimée avec succès.']);
        exit;
    }
}