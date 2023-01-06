<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_accueil_liste');
         }


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/", name="app_create")
     */
    public function create(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, Request $request)
    {
        $createPassword = $request->request->get('create_password');
        $createEmail = $request->request->get('create_email');

        if($createPassword && $createEmail){
            if(!str_contains($createEmail, '@')){
                $this->addFlash('error', 'Votre Email doit contenir un "@"');
            }else{
                $user = new User();
                $user->setEmail($createEmail);

                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $createPassword
                );
                $user->setPassword($hashedPassword);
                $user->setRoles(["ROLE_USER","ROLE_ADMIN"]);
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_accueil_liste');
            }
        }
        return $this->render('security/create.html.twig');
    }
}
