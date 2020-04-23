<?php
namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RolesController
{


  public function __construct(TokenStorageInterface $tokenStorage,  RoleRepository $repo )
  {
    $this->tokenStorage = $tokenStorage;
    $this->repo = $repo;
  }

  public function __invoke(Role $data)
  {

    $data6=$this->repo->findAll();
    $data=$this->repo->findByLibelle("ROLE_ADMIN");
    $data2=$this->repo->findByLibelle2("ROLE_CAISSIER");
    $data3=$this->repo->findByLibelle3("ROLE_PARTENAIRE");
    $data4=$this->repo->findByLibelle4("ROLE_ADMIN_PARTENAIRE");
    $data5=$this->repo->findByLibelle5("ROLE_USER_PARTENAIRE");

    if($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_SUPER_ADMIN"){
 
  $user=[$data,$data2,$data3];
    }
elseif($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_ADMIN"){
    $user=[$data2,$data3];
} 
elseif($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_PARTENAIRE"){
    $user=[$data4,$data5];
} elseif($this->tokenStorage->getToken()->getRoles()[0]=="ROLE_ADMIN_PARTENAIRE"){
    $user=[$data5];
}
return $user;
}
}