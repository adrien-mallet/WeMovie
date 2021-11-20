<?php

namespace App\Twig;

use App\Model\MovieGenre;
use App\Provider\MovieGenreProviderInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    /**
     * @var MovieGenreProviderInterface
     */
    private $genreProvider;

    public function __construct(MovieGenreProviderInterface $genreProvider)
    {
        $this->genreProvider = $genreProvider;
    }

     public function getFunctions(): array
    {
        return [
            new TwigFunction('show_menu', [$this, 'showMenu'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    public function showMenu(Environment $twig)
    {
        return $twig->render('extension/menu.function.html.twig', [
            'genres' => $this->genreProvider->getGenres()
        ]);
    }
}
