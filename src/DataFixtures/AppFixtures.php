<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setLibelle("SUPERADMIN");
        $manager->persist($role);

        $user = new User();
        $user->setPassword($this->encoder->encodePassword($user, "Mbow1994"));
        $user->setRoles(["ROLE_".$role->getLibelle()]);
        $user->setIsActive(true);
        $user->setUsername("Cheikh2");
        $user->setNomComplet("Cheikh");
        $user->setProfil("image");
        $user->setRole($role);

        $manager->persist($user);

        $manager->flush();

    }
}
