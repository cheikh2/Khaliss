<?php
namespace App\Controller;

use App\Entity\Affectation;
use App\Repository\AffectationRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class AffestationController{

protected $tokenStorage;
protected $affec;
    public function __construct(TokenStorageInterface $tokenStorage, AffectationRepository $affec)
    {
        $this->tokenStorage = $tokenStorage;
        $this->affec=$affec;
    }

    public function __invoke(Affectation $data):Affectation
    {  
       
             
    }
}

?>
