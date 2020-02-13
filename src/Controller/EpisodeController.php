<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Form\EpisodeType;
use App\Repository\EpisodeRepository;
use App\Service\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/adminEpisode")
 */
class EpisodeController extends AbstractController
{

    /**
     * @var Slugify
     */
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    /**
     * @Route("/", name="episode_index", methods={"GET"})
     * @param EpisodeRepository $episodeRepository
     * @return Response
     */
    public function index(EpisodeRepository $episodeRepository): Response
    {
        return $this->render('admin/episode/index.html.twig', [
          'episodes' => $episodeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="episode_new", methods={"GET","POST"})
     * @param Request $request
     * @param EpisodeRepository $episodeRepository
     * @return Response
     */
    public function new(Request $request, EpisodeRepository $episodeRepository): Response
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($episode);
            $entityManager->flush();

            return $this->redirectToRoute('episode_index');
        }

        return $this->render('admin/episode/new.html.twig', [
          'episodes' => $episodeRepository->findAll(),
          'episode' => $episode,
          'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="episode_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Episode $episode
     * @return Response
     */
    public function edit(Request $request, Episode $episode): Response
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('episode_index');
        }

        return $this->render('admin/episode/edit.html.twig', [
          'episode' => $episode,
          'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="episode_delete", methods={"DELETE"})
     * @param Request $request
     * @param Episode $episode
     * @return Response
     */
    public function delete(Request $request, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete' . $episode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($episode);
            $entityManager->flush();
        }

        return $this->redirect((string)$request->headers->get('referer'));
    }
}
