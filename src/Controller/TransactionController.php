<?php
namespace App\Controller;

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
        // gérer les frais
        $montantTansact = $data->getMontant();
        //var_dump( $montantTansact);die();
        $tarifs = $tarifsRepo->findByTarifs($montantTansact);
        $frais = $tarifs[0]->getValeur();
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

        $partEnvoyeur = $frais*0.2;
        $data->setPartEnvoyeur($partEnvoyeur);




        // user qui fait retrait
            $userRetrait = $this->tokenStorage->getToken()->getUser();
            $data->setTransfert($userRetrait);

         //compte user connecté
        $CompteUserConnect = $this->tokenStorage->getToken()->getUser()->getAffectations()[0]->getCompte();
        $data->setCompte($CompteUserConnect);

        // user qui fait retrait
        $userTransf = $this->tokenStorage->getToken()->getUser();
        $data->setRetrait($userTransf);

        // Code de transfert
            $code=date_format($data->getCompte()->getCreatedAt(),"hisYms");
            $data->setCode("CT".$code."KOM");

            $frai = $data->getFrais();

            $solCompte = $data->getCompte()->getSolde();
            $montTrans = $data->getMontant();
            $montTotalT = $montTrans - $frai;
            //var_dump($montTotalT);die();

            $compte=$data->getCompte();
            $cni = $data->getCNIEnvoye();
            //var_dump($compte);die();

            if($cni == null AND $solCompte >= $montTrans){
                $compte->setSolde($solCompte - $montTotalT);
                return $data;
            }elseif($cni != null){
                $compte->setSolde($solCompte + $montTrans);
                return $data;
            }
            else{
                throw new Exception("Transaction impossible");
            }

            
    }
}

?>
