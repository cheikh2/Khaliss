<?php
namespace App\Controller;


use DateTime;
use Exception;
use Twilio\Rest\Client;
use App\Entity\Transaction;
use App\Repository\TarifsRepository;
use App\Controller\RetraitController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class RetraitController{

protected $tokenStorage;
protected $tarifsRepo;

    public function __construct(TokenStorageInterface $tokenStorage, TarifsRepository $tarifsRepo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->tarifsRepo=$tarifsRepo;
    }

    public function __invoke(Transaction $data, TarifsRepository $tarifsRepo):Transaction
    {  

        // user qui fait retrait
        $userRetrait = $this->tokenStorage->getToken()->getUser();
        $data->setRetrait($userRetrait);  

         //compte user connecté
         $CompteUserConnect = $this->tokenStorage->getToken()->getUser()->getAffectations()[0]->getCompte();
         $data->setCompteRetrai($CompteUserConnect);
         $solde=$CompteUserConnect->getSolde();

         //part du user qui fait le retrait
            $frai = $data->getFrais();
            $partRetre = $frai*0.2;
            $data->setPartRetreur($partRetre);

         $montantPercu = $data->getMontantPercu();
            
         $cni = $data->getCNIEnvoye();
         
         $stat = $data->getStatut();
        
         if($cni !== null AND $montantPercu>0 AND $stat==true){
            $CompteUserConnect->setSolde($solde + $montantPercu);
            $data->setStatut(false);

  /*    // Your Account SID and Auth Token from twilio.com/console
      $sid = 'AC64f740168529113f75194eff6c8d0f08';
      $token = '9ab0ee745849699882fb55dba2591e39';
      $client = new Client($sid, $token);

      // Use the client to do fun stuff like send text messages!
      $client->messages->create(
    // the number you'd like to send the message to
    '+221 .$data->getTelEnvoyeur()',
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+12055760689',
        // the body of the text message you'd like to send
        'body' => 'Hey Jenny! Good luck on the bar exam!'
    )
);*/
            return $data;
         }else{
            throw new HttpException(403,'Retrait déjà éffectué');
         }

       
}
}
