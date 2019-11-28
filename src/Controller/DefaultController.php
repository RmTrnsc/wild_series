<?php


namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
  /**
   * @Route("/", name="app_index", defaults={"title":"Bienvenue sur le site Wild série"})
   * @param string $title
   * @return Response
   */
  public function index(string $title): Response
  {
    $programs = $this->getDoctrine()
      ->getRepository(Program::class)
      ->findAll();
    shuffle($programs);
    if (!$programs) {
      throw $this->createNotFoundException('No program found in program\'s table.');
    }
    return $this->render('/home.html.twig', [
      'pageTitle' => $title,
      'programs' => $programs
    ]);
  }
}