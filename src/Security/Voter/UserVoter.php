<?php

namespace App\Security\Voter;

use Exception;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserVoter extends Voter
{
    const ROLE_SUPERADMIN ='ROLE_SUPERADMIN';
    const ROLE_ADMIN ='ROLE_ADMIN';
    const ROLE_CAISSIER ='ROLE_CAISSIER';
    private $security;
    private $decisionManager;
    private $tokenStorage;

    public function __construct(Security $security, AccessDecisionManagerInterface $decisionManager, TokenStorageInterface $tokenStorage)
    {
        $this->decisionManager = $decisionManager;
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'ADD', 'VIEW'])
            && $subject instanceof \App\Entity\User;
    }
    /** @var User $subject */
    /** @param User $subject */

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if($this->decisionManager->decide($token, array(self
        ::ROLE_SUPERADMIN))){
            return true;
        }
        $userConnectet=$this->tokenStorage->getToken();
        if($userConnectet->getRoles()[0]==self::ROLE_CAISSIER){
            if($subject->getRoles()[0]==self::ROLE_SUPERADMIN || $subject->getRoles()[0]==self::ROLE_ADMIN 
            || $subject->getRoles()[0]==self::ROLE_CAISSIER){
                return false;
            }
        }elseif($userConnectet->getRoles()[0]==self::ROLE_ADMIN){
            if($subject->getRoles()[0]==self::ROLE_SUPERADMIN || $subject->getRoles()[0]==self::ROLE_ADMIN ){
                return false;
            }
        }
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT':
                if($this->security->isGranted(self::ROLE_ADMIN)){
                    return true;
                }
                break;
            case 'ADD':
                if($this->security->isGranted(self::ROLE_ADMIN)){
                    return true;
                }
                break;
            case 'VIEW':
                    if($this->security->isGranted(self::ROLE_ADMIN)){
                        return true;
                    }
                    break;
                      
        }
        
        throw new \Exception(sprintf('Vous n\'etes pas autorisé d\'effectuer l\'action: %s sur cette ressource', $attribute));
    }
}
