<?php
namespace App\Controller;

use Exception;
use App\Entity\Affectation;
use App\Controller\AffectationController;
use App\Repository\AffectationRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class AffectationController{

protected $tokenStorage;
protected $ripo;
    public function __construct(TokenStorageInterface $tokenStorage, AffectationRepository $ripo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->ripo=$ripo;
    }

    public function __invoke(Affectation $data):Affectation
    { 
        $iDuserCon = $this->tokenStorage->getToken()->getUser()->getPartenaire()->getId();
        $compteAff = $data->getCompte()->getPartenaire()->getId();
        $userAff = $data->getUser()->getPartenaire()->getId();

            if($iDuserCon == $compteAff AND $compteAff == $userAff){
                return $data;
            }else{
                throw new Exception("Affectation non autorisée");
            }
    }
}

?>
