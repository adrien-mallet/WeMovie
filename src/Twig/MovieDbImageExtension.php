<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MovieDbImageExtension extends AbstractExtension
{
    private const BASE_URI = 'https://image.tmdb.org/t/p/%s/%s';

    public function getFunctions(): array
    {
        return [
            new TwigFunction('generate_movie_db_path', [$this, 'generateSrcPath'], ['is_safe' => ['html']]),
        ];
    }

    public function generateSrcPath($size, $path)
    {
        return sprintf(self::BASE_URI, $size, $path);
    }
}
