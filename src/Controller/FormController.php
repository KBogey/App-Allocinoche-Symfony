<?php

namespace App\Controller;

use App\Form\MovieFormType;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
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
        return $this->render('form/index.html.twig', [
            'controller_name' => 'film',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/formactor', name: 'app_form_actor')]
    public function addActor(Request $request): Response
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'acteur',

        ]);
    }

    #[Route('/formdirector', name: 'app_form_director')]
    public function addDirector(Request $request): Response
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'réalisateur',

        ]);
    }
}
