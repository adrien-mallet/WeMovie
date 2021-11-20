<?php

namespace App\Provider;

use App\Model\Movie;

interface MovieProviderInterface
{
    public function getMovie(int $id): Movie;
    public function getMovies(array $genres): \Generator;
    public function searchMovies(string $search): \Generator;
}