<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Repository\EntrepriseRepository;
use App\Repository\SalarieRepository;
use App\Repository\SujetRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/home", name="app_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(SujetRepository $sujetRepository): Response
    {
        $sujet = $sujetRepository->findAll();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'sujets' => $sujet,
        ]);
    }

    /**
     * @Route("/sujet", name="home_sujet")
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
     * @Route("/sujet/{id}", name="home_sujet_id")
     */
    public function sujetId(Request $request, SujetRepository $sujetRepository, EntityManagerInterface $entity, $id): Response
    {
        $sujet = $sujetRepository->findBy(['id' => $id]);

        return $this->render('home/sujet_by_id.html.twig', [
            'sujet' => $sujet,
        ]);
    }

    /**
     * @Route("/message", name="home_message")
     */
    public function message(Request $request, SujetRepository $sujetRepository, EntityManagerInterface $entity): Response
    {
        $sujet = $sujetRepository->findAll();
        $sujetInput = $request->request->get('sujet');



        return $this->render('home/message.html.twig', [
            'sujets' => $sujet,

        ]);
    }
}
