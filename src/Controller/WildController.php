<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{

  /**
   * @Route("/wild", name="wild_index")
   * @return Response
   */
  public function index(): Response
  {
    $programs = $this->getDoctrine()
      ->getRepository(Program::class)
      ->findAll();

    if (!$programs) {
      throw $this->createNotFoundException('No program found in program\'s table.');
    }

    return $this->render('Wild/index.html.twig', [
      'pageTitle' => 'Séries',
      'programs' => $programs
    ]);
  }

  /**
   * @Route("/wild/show/{slug<^[a-zA-Z0-9\-' ']+$>}", defaults={"slug": null}, name="wild_show")
   * @param string|null $slug
   * @return Response
   */
  public function show(?string $slug): Response
  {
    if (!$slug) {
      throw $this->createNotFoundException(
        "Aucune série sélectionnée, veuillez en choisir une"
      );
    }
    $slug = preg_replace(
      '/-/',
      ' ',
      ucwords(trim(strip_tags($slug)), "-")
    );
    $program = $this->getDoctrine()
      ->getRepository(Program::class)
      ->findOneBy(['title' => mb_strtolower($slug)]);
    if (!$program) {
      throw $this->createNotFoundException(
        'No program with ' . $slug . ' title, found in program\'s table'
      );
    }

    return $this->render('/Wild/show.html.twig', [
      'slug' => $slug,
      'program' => $program
    ]);
  }

  /**
   * @Route ("/wild/category/{categoryName<^[a-zA-Z0-9\-]+$>}", name="show_category")
   * @param string $categoryName
   * @return Response
   */
  public function showByCategory(string $categoryName): Response
  {
    if (!$categoryName) {
      throw $this->createNotFoundException(
        'Aucune catégorie selectionnée'
      );
    }

    $category = $this->getDoctrine()
      ->getRepository(Category::class)
      ->findOneBy(['name' =>mb_strtolower($categoryName)]);
    if (!$category) {
      throw $this->createNotFoundException('Aucune catégorie trouvée');
    }

    $programs = $this->getDoctrine()
      ->getRepository(Program::class)
      ->findBy(['category' => $category], ['id' => 'desc'], '3','0');
    if (!$programs) {
      throw $this->createNotFoundException(
        'Aucune série dans la catégorie ' . $categoryName . ' trouvée dans la table'
      );
    }

    return $this->render('/Wild/category.html.twig', [
      'categoryName' => ucwords($categoryName),
      'category' => $category,
      'programs' => $programs,
      'pageTitle' => 'Catégories'
    ]);
  }

  /**
   * @Route("/wild/categories", name="show_categories")
   * @return Response
   */
  public function showAllCategories(): Response
  {
    $categories = $this->getDoctrine()
      ->getRepository(Category::class)
      ->findAll();

    if (!$categories) {
      throw $this->createNotFoundException('No program found in program\'s table.');
    }

    return $this->render('Wild/categories.html.twig', [
      'pageTitle' => 'Catégories',
      'categories' => $categories
    ]);
  }
}