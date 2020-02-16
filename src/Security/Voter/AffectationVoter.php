<?php
namespace App\Security\Voter;

use App\Entity\Affectationn;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AffectationVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ADD' ,'EDIT', 'VIEW'])
            && $subject instanceof \App\Entity\Affectation;
    }

    protected function voteOnAttribute($attribute, $affectation, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        $role = $user->getRole()->getLibelle();
        $roleAff = $affectation->getUser()->getRole()->getLibelle();

        if ($role ==  "PARTENAIRE") {
            if($roleAff == "USER_PARTENAIRE"){
            return true;        
        }else{
            throw new \Exception(sprintf('Affectation non autorisée'));
        }
    }
     
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ADD':
                return $affectation->getCompte()->getId() == $user->getAffectations()[0]->getCompte()->getId();
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'EDIT':
                return $affectation->getCompte()->getId() == $user->getAffectations()[0]->getCompte()->getId();
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
