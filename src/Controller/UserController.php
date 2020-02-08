<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class UserController{

private $entityManager;
private $userPasswordEncoder;
protected $tokenStorage;
    public function __construct( EntityManagerInterface $entityManager,UserPasswordEncoderInterface $userPasswordEncoder,TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->tokenStorage = $tokenStorage;
        
    }

    public function __invoke(User $data): User
    {
        if ($data->getPassword()!=null) {
            $data->setPassword(
            $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
            );
            $data->eraseCredentials();
         }
        return $data;
    }
}
?>