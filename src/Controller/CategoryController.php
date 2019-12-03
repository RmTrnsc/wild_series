<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

  /**
   * @Route("/category", name="new_category", methods={"GET","POST"})
   * @param Request $request
   * @return Response
   */
  public function add(Request $request): Response
  {
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->flush();

      return $this->redirectToRoute('show_categories');
    }

    return $this->render('Form/newCategory.html.twig', [
      'category' => $category,
      'form' => $form->createView()
    ]);
  }

}