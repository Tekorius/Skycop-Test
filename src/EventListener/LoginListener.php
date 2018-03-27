<?php

namespace App\EventListener;

use App\Entity\LoginLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        // Log event
        $log = new LoginLog();
        $log
            ->setUser($user)
            ->setAction(LoginLog::ACTION_LOGIN);

        // Flushing here may produce some hard to debug bugs, but this will do for this example
        $this->em->persist($log);
        $this->em->flush();
    }
}