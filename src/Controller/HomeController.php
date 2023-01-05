<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Sujet;
use App\Entity\User;
use App\Repository\EntrepriseRepository;
use App\Repository\MessageRepository;
use App\Repository\SalarieRepository;
use App\Repository\SujetRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/accueil", name="app_accueil")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/liste", name="_liste")
     */
    public function index(SujetRepository $sujetRepository, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {

        $sujet = $sujetRepository->findAll();

//        $user = new User();
//        $user->setEmail('mathis@gmail.com');
//        $plaintextPassword = 'mathis';
//        $hashedPassword = $passwordHasher->hashPassword(
//            $user,
//            $plaintextPassword
//        );
//        $user->setPassword($hashedPassword);
//        $user->setRoles(["ROLE_USER","ROLE_ADMIN"]);
//        $em->persist($user);
//        $em->flush();



        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sujets' => $sujet,
        ]);
    }

    /**
     * @Route("/sujet/add", name="_home_sujet")
     */
    public function sujet(Request $request, SujetRepository $sujetRepository, EntityManagerInterface $entity): Response
    {
        $sujetInput = $request->request->get('sujet');

        $sujet = new Sujet();
        if(!empty($sujetInput)){
            $sujet->setTitle($sujetInput);
            $sujet->setCreatedAt(new DateTimeImmutable("now"));
            $entity->persist($sujet);
            $entity->flush();
        }

        return $this->render('home/sujet.html.twig', [
            'controller_name' => 'HomeController',

        ]);
    }

    /**
     * @Route("/sujet/{id}", name="_home_sujet_id")
     */
    public function sujetId(Request $request, SujetRepository $sujetRepository,MessageRepository $messageRepository, EntityManagerInterface $entity, $id): Response
    {
        $sujet = $sujetRepository->findBy(['id' => $id]);
        $messageAll = $messageRepository->findBy(['sujet' => $id]);

        return $this->render('home/sujet_by_id.html.twig', [
            'sujet' => $sujet,
            'messages' => $messageAll,
        ]);
    }

    /**
     * @Route("/message/add", name="_home_message")
     */
    public function message(Request $request, SujetRepository $sujetRepository,MessageRepository $messageRepository, EntityManagerInterface $entity): Response
    {
        $sujet = $sujetRepository->findAll();
        $messageAll = $messageRepository->findAll();
        $sujetId = $request->request->get('sujet');
        $messageText = $request->request->get('message');

        $s = $sujetRepository->findBy(['id' => $sujetId]);

        $message = new Message();
        if(!empty($messageText)){
            $message->setText($messageText);
            $message->setCreatedAt(new DateTimeImmutable('now'));
            $message->setSujet($s[0]);
            $message->setUser($this->getUser());

            $entity->persist($message);
            $entity->flush();
        }

        return $this->render('home/message.html.twig', [
            'sujets' => $sujet,
            'messages' => $messageAll,

        ]);
    }
    /**
     * @Route("/message/{id}/modify", name="_home_message_modify")
     */
    public function messageModify(Request $request,MessageRepository $messageRepository, Message $m, EntityManagerInterface $entity, $id): Response
    {
        $message = $messageRepository->findBy(['id' => $id]);
        $messageUpdate = $request->request->get('message');

        if(!empty($messageUpdate)){
            $m->setText($messageUpdate);
            $entity->flush();
        }

        return $this->render('home/message_modify.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/profile", name="_profile")
     */
    public function profile(MessageRepository $messageRepository): Response
    {
        $message = $messageRepository->findAll();

        return $this->render('home/profile.html.twig', [
            'messages' => $message,
        ]);
    }
}
