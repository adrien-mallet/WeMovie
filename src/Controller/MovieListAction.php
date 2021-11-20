<?php

namespace App\Controller;

use App\Provider\MovieProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieListAction extends AbstractController
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
     * @Route("/", name="movie_list")
     */
    public function __invoke(Request $request): Response
    {
        $genres = (array) $request->query->get('genres', []);

        return $this->render(
            'movie-list.action.html.twig',
            [
                'movies' => $this->movieProvider->getMovies($genres)
            ]
        );
    }
}
