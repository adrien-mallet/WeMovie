<?php

namespace App\Provider;

interface MovieGenreProviderInterface
{
    public function getGenres(): \Generator;
}