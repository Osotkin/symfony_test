<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/register', name: 'app_register')]
    public function register(
        Request                      $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler    $guard,
        LoginFormAuthenticator       $authenticator
    )
    {
        if ($request->isMethod('POST')) {
            $user = new User();

            $user
                ->setEmail($request->request->get('email'))
                ->setFirstName($request->request->get('firstName'))
                ->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')))
                ->setIsActive(true)
            ;

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            return $guard->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                "main"
            );
        }

        return $this->render('security/register.html.twig', [
            'error' => '',
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
