<?php
namespace App\DataPersister;


use App\Entity\Transaction;
use App\Repository\RecuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class TransactionPersister implements DataPersisterInterface
{

    private $entityManager;
    private $recu;
    public function __construct(EntityManagerInterface $entityManager, RecuRepository $recu)
    {
        $this->entityManager = $entityManager;
        $this->recu = $recu;
    }

    public function supports($data): bool
    {
        return $data instanceof Transaction;
    }
    
    /**
     * @param Transaction $data
     */
    public function persist($data)
    {
        // generation du recu

       $cniRec = $data->getCNIEnvoye();
    
       $cont = $this->recu->findAll();
       $text = $cont[0]->getContenu();
       

       $nomEme = $data->getNomCEnvoyeur();
       $cniEme = $data->getCNIEnvoyeur();
       $telEme = $data->getTelEnvoyeur();
       $code = $data->getCode();
       $nomRec = $data->getNomCEnvoye();
       $telRec = $data->getTelEnvoye();
       $montantEnv = $data->getMontantPercu();
       $fre = $data->getFrais();

       $date = new DateTime();
       $date = new JsonResponse();
       
       $search = ["#code","#nomEme","#cniEme","#telEme","#nomRec","#telRec","#montantPercu","#fre","#date"];
       $replace = [$code,$nomEme,$cniEme,$telEme,$nomRec,$telRec,$montantEnv,$fre,$date];

       $newtext = str_replace($search,$replace,$text);
    
        $this->entityManager->persist($data);
        $this->entityManager->flush();
if($cniRec==null){
        return new JsonResponse($newtext);
    }
}


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
