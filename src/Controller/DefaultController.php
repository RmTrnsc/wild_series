<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
  /**
   * @Route("/", name="app_index", defaults={"title":"Bienvenue !"})
   * @param string $title
   * @return Response
   */
  public function index(string $title): Response
  {
    return $this->render('/home.html.twig', [
      'pageTitle' => $title
    ]);
  }

}