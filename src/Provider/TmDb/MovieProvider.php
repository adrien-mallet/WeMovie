<?php

namespace App\Provider\TmDb;

use App\Model\Company;
use App\Model\Movie;
use App\Model\MovieVideo;
use App\Provider\MovieProviderInterface;
use Generator;
use RuntimeException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieProvider implements MovieProviderInterface
{
    use ProviderTrait;

    private const MOVIE_LIST_URL = '/3/discover/movie';
    private const MOVIE_URL = '/3/movie/%s';
    private const MOVIE_SEARCH_URL = '/3/search/movie';

    /**
     * @var HttpClientInterface
     */
    private $tmdbClient;

    /**
     * @var string
     */
    private $tmdbKey;
    /**
     * @var CacheInterface
     */
    private $tmdbCache;

    public function __construct(CacheInterface $tmdbCache, HttpClientInterface $tmdbClient, string $tmdbKey)
    {
        $this->tmdbClient = $tmdbClient;
        $this->tmdbKey = $tmdbKey;
        $this->tmdbCache = $tmdbCache;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws RuntimeException
     */
    public function getMovies(array $genres): Generator
    {
        $response = $this->tmdbClient->request('GET', self::MOVIE_LIST_URL, [
            'query' => [
                'api_key' => $this->tmdbKey,
                'language' => 'fr-FR',
                'include_video' => true,
                'sort_by' => 'popularity.desc',
                'with_genres' => implode(',', $genres)
            ]
        ]);

        $decodedResponse = $this->decodeJsonResponse($response);

        foreach ($decodedResponse->results as $movie) {
            yield $this->getMovie($movie->id);
        }
    }

    public function getMovie(int $id): Movie
    {
        $response = $this->tmdbClient->request('GET', sprintf(self::MOVIE_URL, $id), [
            'query' => [
                'api_key' => $this->tmdbKey,
                'language' => 'fr-FR',
                'append_to_response' => 'videos'
            ]
        ]);

        $movie = $this->decodeJsonResponse($response);

        return new Movie(
            $movie->id,
            $movie->poster_path,
            $movie->backdrop_path,
            $movie->overview,
            $movie->release_date,
            $movie->title,
            $movie->vote_count,
            $movie->vote_average,
            array_map(function ($company) {return new Company($company->id, $company->name);}, $movie->production_companies),
            array_map(function ($video) {return new MovieVideo($video->id, $video->name, $video->site, $video->key);}, $movie->videos->results)[0] ?? null,
            $movie->video
        );
    }

    public function searchMovies(string $search): \Generator
    {
        $response = $this->tmdbClient->request('GET', self::MOVIE_SEARCH_URL, [
            'query' => [
                'api_key' => $this->tmdbKey,
                'language' => 'fr-FR',
                'query' => $search
            ]
        ]);

        $decodedResponse = $this->decodeJsonResponse($response);

        foreach ($decodedResponse->results as $movie) {
            yield $this->getMovie($movie->id);
        }
    }
}