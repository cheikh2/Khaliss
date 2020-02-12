<?php

namespace App\Security\Voter;

use App\Entity\Transaction;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TransactionVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ADD' ,'EDIT', 'VIEW'])
            && $subject instanceof \App\Entity\Transaction;
    }

    protected function voteOnAttribute($attribute, $transaction, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        $role = $user->getRole()->getLibelle();

        if ($role ==  "SUPERADMIN" || $role ==  "ADMIN") {
            return true; 
        }
     
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ADD':
                return $transaction->getCompte()->getId() == $user->getAffectations()[0]->getCompte()->getId();
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
