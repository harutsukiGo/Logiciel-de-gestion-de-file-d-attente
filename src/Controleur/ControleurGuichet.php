<?php
namespace App\file\Controleur;

use App\file\Modele\Repository\GuichetsRepository;

class ControleurGuichet extends ControleurGenerique
{

    public static function recupererListeGuichet()
    {
       echo json_encode((new GuichetsRepository())->recupererGuichets());
    }
}