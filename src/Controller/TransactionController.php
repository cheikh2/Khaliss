<?php
namespace App\Controller;

use App\Entity\Transaction;
use App\Controller\TransactionController;
use App\Repository\TransactionRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class TransactionController{

protected $tokenStorage;
protected $ripo;
    public function __construct(TokenStorageInterface $tokenStorage, TransactionRepository $ripo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->ripo=$ripo;
    }

    public function __invoke(Transaction $data):Transaction
    {  
       
             
    }
}

?>
