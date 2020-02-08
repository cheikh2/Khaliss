<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Controller\DepotController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;



class DepotController
{
    public function __invoke(Depot $data):Depot
    {
        $montant=$data->getMontant();
        $compte=$data->getCompte();
        $solde=$compte->getSolde();
        if($montant > 0){
            $compte->setSolde($solde + $montant);
            return $data;
        }else{
            throw new Exception("Le montant doit etre superieur à 0");
        }
    }
}