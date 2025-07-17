<?php
namespace App\file\Controleur;

use App\file\Modele\Repository\PubliciteRepository;

class ControleurPublicite extends ControleurGenerique
{
    function afficherPublicites()
    {
        (new PubliciteRepository())->recuperer();
    }
}