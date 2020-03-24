<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


final class BlagController 
{

    public function __construct(UserRepository $use)
    {
        $this->use = $use;
    }


    public function __invoke(UserRepository $use)
{
 $data=$this->use->findAll();
 foreach($data as $value){
     if($value->getImage()){
         $value->setImage(base64_encode(stream_get_contents($value->getImage())));
     }
 }
        return $data;
     
        
}

}