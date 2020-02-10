<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
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
            return $this->render('Error/_error.html.twig');
        }

        return $this->render('Wild/index.html.twig', [
          'pageTitle' => 'Séries',
          'programs' => $programs
        ]);
    }

    /**
     * @Route("/wild/show/{slug}", defaults={"slug": null}, name="wild_show")
     * @param string|null $slug
     * @return Response
     */
    public function show(?string $slug): Response
    {
        $slug = str_replace(' ', '-', strtolower($slug));

        $program = $this->getDoctrine()
          ->getRepository(Program::class)
          ->findOneBy(['slug' => $slug]);

        if (!$slug || !$program) {
            return $this->render('Error/_error.html.twig');
        }

        return $this->render('/Wild/show.html.twig', [
          'slug' => $slug,
          'program' => $program
        ]);
    }

    /**
     * @Route ("/wild/category/{categoryName<^[a-zA-Z0-9\-' ']+$>}", name="show_category")
     * @param string|null $categoryName
     * @return Response
     */
    public function showByCategory(?string $categoryName): Response
    {
        $category = $this->getDoctrine()
          ->getRepository(Category::class)
          ->findOneBy(['name' => mb_strtolower($categoryName)]);


        $programs = $this->getDoctrine()
          ->getRepository(Program::class)
          ->findBy(['category' => $category], ['title' => 'asc']);

        if (!$categoryName || !$category || !$programs) {
            return $this->render('Error/_error.html.twig');
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
            return $this->render('Error/_error.html.twig');
        }

        return $this->render('Wild/categories.html.twig', [
          'pageTitle' => 'Catégories',
          'categories' => $categories
        ]);
    }

    /**
     * @Route("/program/{programName}", defaults={"programName" = null}, name="show_program")
     * @param string|null $programName
     * @return Response
     */
    public function showByProgram(?string $programName): Response
    {
        $program = $this->getDoctrine()
          ->getRepository(Program::class)
          ->findOneBy(['title' => $programName]);


        $seasons = $this->getDoctrine()
          ->getRepository(Season::class)
          ->findBy(['program' => $program]);

        if (!$programName || !$program || $seasons) {
            return $this->render('Error/_error.html.twig');
        }

        return $this->render('Wild/program.html.twig', [
          'programName' => $programName,
          'program' => $program,
          'seasons' => $seasons
        ]);
    }

    /**
     * @Route("/season/{id}", defaults={"id" = null}, name="show_episodes")
     * @param int|null $id
     * @return Response
     */
    public function showBySeason(?int $id): Response
    {
        if (!$id) {
            return $this->render('Error/_error.html.twig');
        }

        $season = $this->getDoctrine()
          ->getRepository(Season::class)
          ->findOneBy(['id' => $id]);

        $program = $season->getProgram();
        $episodes = $season->getEpisodes();

        return $this->render('Wild/episodes.html.twig', [
          'season' => $season,
          'program' => $program,
          'episodes' => $episodes,
          'id' => $id
        ]);
    }

    /**
     * @Route("/episode/{id}", name="show_episode")
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Episode $episode): Response
    {
        $episode->getSeason()->getProgram();
        $picture = $episode->getImages();

        return $this->render('Wild/episode.html.twig', [
          'episode' => $episode,
          'picture' => $picture
        ]);
    }
}
