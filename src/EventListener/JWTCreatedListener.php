<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\Exception\DisabledException;

class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var $user \AppBundle\Entity\User */
        $user = $event->getUser();

        if($user->getPartenaire()!=null && !$user->getPartenaire()->getUsers()[0]->getIsActive()){
            throw new DisabledException('Compte bloqué');
        }
        // bloqué les utilisateurs
        elseif(!$user->getIsActive()){
            throw new DisabledException('count is');
        }

       
        // merge with existing event data
        $payload = array_merge(
            $event->getData(),
            [
                'password' => $user->getPassword()
            ]
        );

        $event->setData($payload);
    }
}