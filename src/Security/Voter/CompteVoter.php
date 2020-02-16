<?php
namespace App\Security\Voter;

use Exception;
use App\Entity\Compte;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CompteVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ADD', 'EDIT', 'VIEW'])
            && $subject instanceof \App\Entity\Compte;
    }

    protected function voteOnAttribute($attribute, $compte, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        $role = $user->getRole()->getLibelle();

    
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
                case 'ADD':
                    if ($role ==  "SUPERADMIN" || $role ==  "ADMIN") {
                        return true; 
                    }
            
                    // logic to determine if the user can EDIT
                    // return true or false
                    break;
                case 'EDIT':
                    if ($role ==  "SUPERADMIN" || $role ==  "ADMIN") {
                        return true; 
                    }
                    // logic to determine if the user can VIEW
                    // return true or false
                    break;
                case 'VIEW':
                    if ($role ==  "SUPERADMIN" || $role ==  "ADMIN") {
                        return true; 
                    }
                    // logic to determine if the user can VIEW
                    // return true or false
                    break;
        }

        throw new \Exception(sprintf('Vous n\'etes pas autorisé d\'effectuer l\'action: %s sur compte', $attribute));
    }
}
