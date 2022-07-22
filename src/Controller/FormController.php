<?php

namespace App\Controller;

use App\Form\MovieFormType;
use App\Form\ActorFormType;
use App\Form\DirectorFormType;
use App\Form\FormReviewType;
use App\Entity\Movie;
use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Review;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MovieRepository $movieRepository,
    ) {
    }

    #[Route('/form', name: 'app_form_template')]
    public function index(): Response
    {
        return $this->render('form/indexForm.html.twig');
    }

    #[Route('/formmovie', name: 'app_form_movie')]
    public function addMovie(Request $request): Response
    {
        $movieEntity = new Movie();
        $form = $this->createForm(MovieFormType::class, $movieEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($movieEntity);
            $this->entityManager->persist($movieEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_form_movie');
        }

        return $this->render('form/indexFormMovie.html.twig', [
            'controller_name' => 'film',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/formactor', name: 'app_form_actor')]
    public function addActor(Request $request): Response
    {
        $actorEntity = new Actor();
        $form = $this->createForm(ActorFormType::class, $actorEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($actorEntity);
            $this->entityManager->persist($actorEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_form_actor');
        }

        return $this->render('form/indexFormActor.html.twig', [
            'controller_name' => 'acteur',
            'form' => $form->createView(),

        ]);
    }

    #[Route('/formdirector', name: 'app_form_director')]
    public function addDirector(Request $request): Response
    {
        $directorEntity = new Director();
        $form = $this->createForm(DirectorFormType::class, $directorEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($directorEntity);
            $this->entityManager->persist($directorEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_form_director');
        }
        return $this->render('form/indexFormDirector.html.twig', [
            'controller_name' => 'réalisateur',
            'form' => $form->createView(),

        ]);
    }

    #[Route('/formreview/{movieId}', name: 'app_form_review')]
    public function addReview(Request $request, $movieId): Response
    {
        $movieEntity = $this->movieRepository->find($movieId);
        $user = $this->getUser();

        $reviewEntity = new Review();
        $reviewEntity->setCreatedAt(new DateTime());
        $reviewEntity->setMovie($movieEntity);
        $reviewEntity->setUser($user);

        $form = $this->createForm(FormReviewType::class, $reviewEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($reviewEntity);
            $this->entityManager->persist($reviewEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_allo_cine_movielist');
        }

        return $this->render('form/indexFormReview.html.twig', [
            'controller_name' => 'commentaire',
            'form' => $form->createView(),
        ]);
    }
}
