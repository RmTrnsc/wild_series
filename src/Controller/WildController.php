<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{

  /**
   * @Route("/wild", name="wild_index")
   */
  public function index(): Response
  {
    return $this->render('WildSeries/index.html.twig', [
      'pageTitle' => 'Wild Séries'
    ]);
  }

  /**
   * @Route("/wild/show/{slug}", name="wild_series_show",
   * defaults={"slug":""}, requirements={"slug":"[a-z0-9\-]+"})
   * @param $slug
   * @return Response
   */
  public function show($slug): Response
  {
    if ($slug == "") {
      $slug = "Aucune série sélectionnée, veuillez en choisir une";
    } else {
      $slug = str_replace('-', ' ', $slug);
      $slug = ucwords($slug);
    }
    return $this->render('/WildSeries/show.html.twig', [
      'slug' => $slug,
      'pageTitle' => 'Wild Séries'
    ]);
  }
}