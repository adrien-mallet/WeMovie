<?php

namespace App\Controller;

use App\Provider\TmDb\MovieProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieAction extends AbstractController
{
    /**
     * @var MovieProvider
     */
    private $movieProvider;

    public function __construct(MovieProvider $movieProvider)
    {
        $this->movieProvider = $movieProvider;
    }

    /**
     * @Route("/movie/{movieId<\d+>}", name="movie_details")
     */
    public function __invoke(Request $request, int $movieId): Response
    {
        return $this->render('movie.action.html.twig', [
            'movie' => $this->movieProvider->getMovie($movieId)
        ]);
    }
}
