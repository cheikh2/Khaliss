<?php
namespace App\Controller;

use App\Entity\Depot;
use App\Controller\DepotController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class DepotController
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Depot $data):Depot
    {
        // User qui fait le depot
        $userConnect = $this->tokenStorage->getToken()->getUser();
        $data->setUser($userConnect);

        $montant = $data->getMontant();  
        $compte=$data->getCompte();
        $solde=$compte->getSolde();
        if($montant >= 50){
            $compte->setSolde($solde + $montant);
            return $data;
        }else{
            throw new Exception("Le montant doit être au minimum 50");
        }
    }
}