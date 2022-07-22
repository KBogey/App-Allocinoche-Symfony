<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use App\Repository\DirectorRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlloCineController extends AbstractController
{
    public function __construct(
        private MovieRepository $movieRepository,
        private ActorRepository $actorRepository,
        private ReviewRepository $reviewRepository,
        private DirectorRepository $directorRepository,
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $entityManagerInterface,
    ) {
    }

    #[Route('/', name: 'app_allo_cine')]
    public function index(): Response
    {

        return $this->render('allo_cine/index.html.twig', [
            'controller_name' => 'Allociné',
        ]);
    }

    #[Route('/allo/cine/movielist', name: 'app_allo_cine_movielist')]
    public function indexMovieList(): Response
    {
        $movieEntities = $this->movieRepository->findAll();

        return $this->render('allo_cine/indexMovieList.html.twig', [
            'controller_name' => 'la liste de films',
            'movies' => $movieEntities,
        ]);
    }

    #[Route('/allo/cine/movie{movieId}', name: 'app_allo_cine_moviedetail')]
    public function indexMovieDetail($movieId): Response
    {
        $note = 0;
        $diviseur = 0;

        $movieEntity = $this->movieRepository->find($movieId);
        // $reviewEntities = $this->reviewRepository->findBy(['movie' => $movieEntity]);
        $reviewEntities = $movieEntity->getReviews();

        foreach ($reviewEntities as $review) {
            $note += $review->getNote();
            $diviseur += 1;
        }
        if ($diviseur == 0) {
            $roundNote = null;
        } else {
            $roundNote = $note / $diviseur;
        }



        return $this->render('allo_cine/indexMovieDetail.html.twig', [
            'movie' => $movieEntity,
            'reviews' => $reviewEntities,
            'note' => $roundNote,
        ]);
    }

    #[Route('/allo/cine/actorlist', name: 'app_allo_cine_actorlist')]
    public function indexActorList(): Response
    {
        $actorEntities = $this->actorRepository->findAll();

        return $this->render('allo_cine/indexActorList.html.twig', [
            'controller_name' => 'la liste d\'acteurs',
            'actors' => $actorEntities,
        ]);
    }

    #[Route('/allo/cine/actor{actorId}', name: 'app_allo_cine_actordetail')]
    public function indexActorDetail($actorId): Response
    {
        $actorEntity = $this->actorRepository->find($actorId);

        return $this->render('allo_cine/indexActorDetail.html.twig', [
            'actor' => $actorEntity,
        ]);
    }

    #[Route('/allo/cine/directorlist', name: 'app_allo_cine_directorlist')]
    public function indexDirectorList(): Response
    {
        $directorEntities = $this->directorRepository->findAll();

        return $this->render('allo_cine/indexDirectorList.html.twig', [
            'controller_name' => 'la liste des réalisateurs',
            'directors' => $directorEntities,
        ]);
    }

    #[Route('/allo/cine/director{directorId}', name: 'app_allo_cine_directordetail')]
    public function indexDirectorDetail($directorId): Response
    {
        $directorEntity = $this->directorRepository->find($directorId);

        return $this->render('allo_cine/indexDirectorDetail.html.twig', [
            'director' => $directorEntity,
        ]);
    }

    #[Route('/allo/cine/movieCategory/{categoryId}', name: 'app_allo_cine_moviecategory')]
    public function indexMovieCategory($categoryId): Response
    {
        $category = $this->categoryRepository->find($categoryId);
        $movieEntities = $category->getMovies();

        return $this->render('allo_cine/indexMovieCategory.html.twig', [
            'movies' => $movieEntities,
        ]);
    }
}
