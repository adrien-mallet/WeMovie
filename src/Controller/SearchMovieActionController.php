<?php

namespace App\Controller;

use App\Provider\MovieProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchMovieActionController extends AbstractController
{
    /**
     * @var MovieProviderInterface
     */
    private $movieProvider;

    public function __construct(MovieProviderInterface $movieProvider)
    {
        $this->movieProvider = $movieProvider;
    }

    /**
     * @Route("/search/movie", name="search_movie")
     */
    public function __invoke(Request $request): Response
    {
        $search = $request->query->get('search', null);

        if (is_null($search))
        {
            $this->redirectToRoute('movie_list');
        }

        $movies = $this->movieProvider->searchMovies($search);

        if ($request->isXmlHttpRequest()) {
            return $this->json($movies);
        }

        return $this->render('movie-search.action.html.twig', [
            'movies' => $movies,
        ]);
    }
}
