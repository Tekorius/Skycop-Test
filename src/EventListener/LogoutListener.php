<?php

namespace App\EventListener;

use App\Entity\LoginLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * This method is called by the LogoutListener when a user has requested
     * to be logged out. Usually, you would unset session variables, or remove
     * cookies, etc.
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();

        // Log event
        $log = new LoginLog();
        $log
            ->setUser($user)
            ->setAction(LoginLog::ACTION_LOGOUT);

        // This may introduce some hard to debug issues, but again, this is just a demo
        $this->em->persist($log);
        $this->em->flush();
    }
}