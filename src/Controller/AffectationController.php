<?php
namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Affectation;
use App\Controller\AffectationController;
use App\Repository\AffectationRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class AffectationController{

protected $tokenStorage;
protected $ripo;
    public function __construct(TokenStorageInterface $tokenStorage, AffectationRepository $ripo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->ripo=$ripo;
    }

    public function __invoke(Affectation $data):Affectation
    { 
        
        /*
        //Verifier si l'utilisateur Courant est affecte a un autre Compte dans cette meme periode
 $AffectationC = $this->ripo->findAll();
 
 for ($i=0; $i < count($AffectationC); $i++) { 
     
     $dateDebut = $AffectationC[$i]->getDateAffectation();
     $dateFin = $AffectationC[$i]->getDateExpiration();
     
     $userAffectC = $AffectationC[$i]->getUser()->getId();
     $compteAffect = $AffectationC[$i]->getCompte()->getId();
//var_dump($compteAffect);die();
     $date=new DateTime();
     $dateDebut=$data->getDateAffectation();
     $dateFin=$data->getDateExpiration();
     $userAff= $data->getUser()->getId();
     $compteAff= $data->getCompte()->getId();*/

    /* if($dateDebut < $date AND $dateFin > $date AND $userAffectC == $compteAffect)
     {
        throw new Exception("Ce compte a été déjà affecté");
         //throw new Exception("Le Compte Nº: ".$data->getCompte()->getNumCompte()." est dejà affecté à l'utilisateur ".$data->getUserAffectCompte()->getUsername()." dans cette meme période");
     }
 
*/

        $date=new DateTime();
        $dateDebut=$data->getDateAffectation();
        $dateFin=$data->getDateExpiration();
        // user affecteur
        $userAffecteur =  $this->tokenStorage->getToken()->getUser();
        $data->setAffecteur($userAffecteur);
        
        $iDuserCon = $this->tokenStorage->getToken()->getUser()->getPartenaire()->getId();
        $compteAff = $data->getCompte()->getPartenaire()->getId();
        $userAff = $data->getUser()->getPartenaire()->getId();


            if($iDuserCon == $compteAff AND $compteAff == $userAff AND $dateFin > $date){
                return $data;
            }else{
                throw new Exception("Affectation non autorisée");
            }
    }
}

?>
