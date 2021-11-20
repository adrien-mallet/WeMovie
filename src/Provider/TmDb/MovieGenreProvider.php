<?php

namespace App\Provider\TmDb;

use App\Model\MovieGenre;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieGenreProvider implements \App\Provider\MovieGenreProviderInterface
{
    use ProviderTrait;

    private const GENRE_LIST_URL = 'genre/movie/list';

    /**
     * @var HttpClientInterface
     */
    private $tmdbClient;
    /**
     * @var string
     */
    private $tmdbKey;

    public function __construct(HttpClientInterface $tmdbClient, string $tmdbKey)
    {
        $this->tmdbClient = $tmdbClient;
        $this->tmdbKey = $tmdbKey;
    }

    public function getGenres(): \Generator
    {
        $response = $this->tmdbClient->request('GET', self::GENRE_LIST_URL, [
            'query' => [
                'api_key' => $this->tmdbKey,
                'language' => 'fr-FR'
            ]
        ]);

        $decodedResponse = $this->decodeJsonResponse($response);

        foreach ($decodedResponse->genres as $genre) {
            yield new MovieGenre($genre->id, $genre->name);
        }
    }
}