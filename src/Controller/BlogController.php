<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


final class BlogController 
{

    public function __invoke(UserRepository $use)
{
 

  ###########################DECLARATION DES VARIABLES#####################
       ##########################################################################*
       //Je recuppere l'image
       
        $url=$_SERVER["REQUEST_URI"]; 
        $ex=explode("/",$url);
        $id=$ex[3];
        $data=$use->find($id);
      //explose de l'url
      $data->setImage(base64_encode(stream_get_contents($data->getImage())));
        
        ###########################TRAITEMENT DES DONNEES#####################
         ##########################################################################
        return $data;
     
        
}

}