<?php
namespace App\Controller;

use App\Osms;
use DateTime;
use Exception;
use App\Entity\Transaction;
use App\Repository\TarifsRepository;
use App\Controller\TransactionController;
use App\Repository\TransactionRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



class TransactionController{

protected $tokenStorage;
protected $repo;
protected $tarifsRepo;
    public function __construct(TokenStorageInterface $tokenStorage, TransactionRepository $repo, TarifsRepository $tarifsRepo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->repo=$repo;
        $this->tarifsRepo=$tarifsRepo;
        
    }

    public function __invoke(Transaction $data, TarifsRepository $tarifsRepo):Transaction
    {  
        $date=new DateTime();

        // gérer les frais
        $montantTansact = $data->getMontant();
        $tarifs =$this->tarifsRepo->findTarifs($montantTansact);
        $frais = $tarifs[0]->getValeur();
       // var_dump($frais);die();
        $data->setFrais($frais);

        $montantPercu= $montantTansact - $frais;
        $data->setMontantPercu($montantPercu);

        if($montantTansact>=2000000){
            $frais = ($montantPercu * 0.02);
        }

        $partEta = $frais*0.4;
        $data->setPartEtat($partEta);

        $partSys = $frais*0.3;
        $data->setPartSysteme($partSys);

        $partEnvoyeur = $frais*0.1;
        $data->setPartEnvoyeur($partEnvoyeur);

         //compte user connecté
        $CompteUserConnect = $this->tokenStorage->getToken()->getUser()->getAffectations()[0]->getCompte();
        $data->setCompte($CompteUserConnect);

        
        // user qui fait le transfert
        $userTransf = $this->tokenStorage->getToken()->getUser();
        $data->setTransfert($userTransf);

        // Code de transfert
            $code=date_format($data->getDateTrans(),"k.hisi");
            $data->setCode($code);

            $frai = $data->getFrais();

            $solCompte = $data->getCompte()->getSolde();
            $montTrans = $data->getMontant();
            $montTotalT = $montTrans - $frai;
        
            $compte=$data->getCompte();
            $cni = $data->getCNIEnvoye();

            // recuperation des dates d'affectations
            $debutAff=$data->getCompte()->getAffectations()[0]->getDateAffectation();
            $finAff=$data->getCompte()->getAffectations()[0]->getDateExpiration();
 
            // recuperation du role du user 
             $role = $data->getTransfert()->getRoles()[0];
          //  var_dump($role);die();
            
            if($cni == null){
                if($role== "ADMIN_PARTENAIRE" || $role== "USER_PARTENAIRE"){
                    $compte->setSolde($solCompte - $montTotalT);
                        if( $solCompte < $montTrans){
                            throw new Exception("solde insuffisant");
                    
                }
                
                if($debutAff>$date || $finAff<$date){
                    throw new Exception("Date d'affection non valide pour ce compte");
                }
                
               // if($role== "PARTENAIRE"){}


                $config = array(
                    'clientId' => 'YBwMEAU6OK0siaQoYgwc48RtAelb8Wdr',
                    'clientSecret' => 'uwdidO9H6IjvVFn2'
                );
                
                $osms = new Osms($config);
                
                // retrieve an access token
                $response = $osms->getTokenFromConsumerKey();
                
                if (!empty($response['access_token'])) {
                    $senderAddress = 'tel:+221'.$data->getTelEnvoyeur();
                    $receiverAddress = 'tel:+221'.$data->getTelEnvoye();
                    $message = 'Bienvenu chez komkom ' . $data->getNomCEnvoyeur() ." vient de vous envoyer ". $data->getMontantPercu(). " FCFA le code de retraie est: ".
                    $data->getCode(). " komkom vous remercie ";
                    $senderName = 'komkom';
                
                    $osms->sendSMS($senderAddress, $receiverAddress, $message, $senderName);
                } else {
                    // error
                }
                return $data;    
            }
            else{
                throw new Exception("Transaction impossible");
            }
        }
            
    }
}

?>
