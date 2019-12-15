<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Program;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/actors", name="actor", defaults={"id"=null})
     * @param ActorRepository $actorRepository
     * @return Response
     */
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render('actor/index.html.twig', [
          "actors" => $actorRepository->findAll()
        ]);
    }

    /**
     * @Route("/actorProgram/{id}", name="actorProgram")
     * @param Program $program
     * @param int $id
     * @return Response
     */
    public function showByProgram(Program $program, int $id): Response
    {

        $actor = $this->getDoctrine()
          ->getRepository(Actor::class)
          ->findOneBy(['id' => $id]);

        $programs = $actor->getPrograms();

        return $this->render('actor/show.html.twig', [
          'program' => $program,
          'programs' => $programs,
          'actor' => $actor
        ]);
    }
}
