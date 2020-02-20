<?php
namespace App\Controller;


use Exception;
use App\Entity\Transaction;
use App\Controller\RetraitController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class RetraitController{

protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Transaction $data):Transaction
    {  
        $cni = $data->getCNIEnvoye();
        $stat = $data->getStatut();

        if($cni == null AND $stat == true){
            $data->setStatut(false);
            $data->setCNIEnvoye($cni);
        }
        return $data; 
       
         //  throw new Exception("Yaaaaaaaaaaaaaaaaa");

       
}
}
