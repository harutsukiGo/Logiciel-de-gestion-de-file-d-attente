<?php

namespace App\file\Modele\DataObject;

enum enumPublicite: string
{
    case IMAGE = 'image';
    case  VIDEO = 'vidéo';

    public function getValue(): string {
        return $this->value; }
}
