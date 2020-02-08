<?php
namespace App\DataPersister;

use App\Entity\User;
use App\DataPersister\UserDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DataPersister implements DataPersisterInterface
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, TokenStorageInterface $tokenStorage)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function supports($data): bool
    {
        return $data instanceof User;
    }
    
    /**
     * @param User $data
     */
    public function persist($data)
    {
        
       /* if($data->getPassword()) {
            $data->setPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
        }*/
    
        $this->entityManager->persist($data);
        $this->entityManager->flush();
}


    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
