<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * This class is responsible for editing user account and registering new accounts
 *
 * @Route("/account", name="account_")
 */
class AccountController extends Controller
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    /**
     * @Route("/", name="edit")
     */
    public function edit(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Parse password. Whether to set or not to set is handled by the function itself
            $this->parsePassword($user, $form->get('password')->getData());

            // Success message
            $this->addFlash('success', 'Saved!');

            // Flush
            $this->getDoctrine()->getManager()->flush();

            // Redirect back to self to prevent additional submits by refresh
            return $this->redirectToRoute('account_edit');
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['registration' => true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Parse password since we're not stupid to save a plain text password
            $this->parsePassword($user, $form->get('password')->getData());

            // Success message just for sexyness
            $this->addFlash('success', 'Account created! You can now log in');

            // Flush and redirect
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function parsePassword(User $user, $plainPass)
    {
        if (null !== $plainPass && '' !== trim($plainPass)) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPass));
        }
    }
}