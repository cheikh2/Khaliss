<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Entity\Depots;
use App\Repository\RoleRepository;
use App\Repository\DepotRepository;
use App\Controller\CompteController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;
private $repo;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage,
    RoleRepository $repo)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        $this->repo=$repo;
    }

    public function __invoke(Compte $data):Compte
    {  
        //user createur
        $userConnect = $this->tokenStorage->getToken()->getUser();
        $data->setUser($userConnect);


        if($data->getPartenaire()!=null){
         // je crypte le mot de passe du propriaite du compte
           $passw=$this->userPasswordEncoder->encodePassword($data->getPartenaire()->getUsers()[0],
           $data->getPartenaire()->getUsers()[0]->getPassword());
           $data->getPartenaire()->getUsers()[0]->setPassword($passw);

             } 
              //Gérer le solde 
        $sold=$data->getDepots()[0]->getMontant();
        $data->setSolde($sold);
        
        if($sold>500000){
            return $data;
            
         }else{
            throw new Exception("Le montant doit etre superieur ou égale à 500.000");
        }   
             
    }
}

?>
