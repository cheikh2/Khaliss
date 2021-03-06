<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


final class ImageController 
{

    public function __invoke(User $data, UserRepository $use): User
{
 

  ###########################DECLARATION DES VARIABLES#####################
       ##########################################################################*
       //Je recuppere l'image
       if(isset($_FILES['image'])){
        $image=file_get_contents($_FILES['image']['tmp_name']);
        //url
        $url=$_SERVER["REQUEST_URI"]; 
        $ex=explode("/",$url);
        $id=$ex[4];
        $data=$use->find($id);
      //explose de l'url
        
        ###########################TRAITEMENT DES DONNEES#####################
         ##########################################################################
        $data->setImage(($image));
        return $data;
     
      
    }else{
      return new JsonResponse($_FILES);
    }
        
}

}