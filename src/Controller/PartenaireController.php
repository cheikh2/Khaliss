<?php
namespace App\Controller;

use App\Entity\Partenaire;
use App\Controller\TransactionController;
use App\Repository\TransactionRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class PartenaireController{

protected $tokenStorage;
protected $ripo;
    public function __construct(TokenStorageInterface $tokenStorage, TransactionRepository $ripo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->ripo=$ripo;
    }

    public function __invoke(Partenaire $data):Partenaire
    {  
        
    }
}

?>
