<?php
namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


class StatuController{

    public function __construct(UserRepository $repo)
    {
        
        $this->repo=$repo;
    }

    public function __invoke(User $data, UserRepository $repo, $id): User
    {
        $user = $repo->find($id);

       // $status = '';
        if($user->getIsActive()===true){
           // $status = 'Desactivé';
            $user->setIsActive(false);
        }else{
           // $status = 'Activé';
            $user->setIsActive(true);
        }
    return $user;
    //throw new Exception("Statut de ".$user->getUsername(). " modifié avec succès");
    /*$data = [
        'status'=>200,
        'message'=>$user->getUsername(). ' est '.$status
    ];
    return new JsonResponse($data, 200);*/
    }
}
?>