<?php
namespace App\file\Modele\DataObject;

enum enumPublicite
{
    case image;
    case video;

    public function getType(): enumPublicite
    {
        return $this;
    }
}
