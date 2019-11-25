<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{

  /**
   * @Route("/wild_serie", name="wild_index")
   * @return Response
   */
  public function index(): Response
  {
    return $this->render('/Wild/index.html.twig', [
      'pageTitle' => 'Wild Séries'
    ]);
  }

}