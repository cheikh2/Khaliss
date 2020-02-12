<?php
namespace App\DataPersister;


use App\Entity\Compte;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class DataPersister implements DataPersisterInterface
{

    private $entityManager;
    private $contrat;
    public function __construct(EntityManagerInterface $entityManager, ContratRepository $contrat)
    {
        $this->entityManager = $entityManager;
        $this->contrat = $contrat;
    }

    public function supports($data): bool
    {
        return $data instanceof Compte;
    }
    
    /**
     * @param Compte $data
     */
    public function persist($data)
    {
        
       $term = $this->contrat->findAll();
       $text = $term[0]->getTerme();

       $nom = $data->getPartenaire()->getUsers()[0]->getNomcomplet();
       $ninea = $data->getPartenaire()->getNinea();
       $search = ["#nomComplet","#ninea"];
       $replace = [$nom,$ninea];

       $newtext = str_replace($search,$replace,$text);
    
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return new JsonResponse($newtext);
}


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
