<?php
namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class RoleController 
{
    protected $tokenStorage;
    private $ripo;

    public function __construct(RoleRepository $ripo,TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->ripo = $ripo;
    }


    public function __invoke(Role $data, RoleRepository $ripo, $id):Role
    {
        $role = $ripo->find($id);
        var_dump($role);die();
      /*  // User qui fait le depot
        $userConnect = $this->tokenStorage->getToken()->getUser();
        var_dump($userConnect);die();
        $data->setUser($userConnect);*/
    }
       

}