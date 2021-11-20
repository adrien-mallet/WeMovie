<?php

namespace App\Model;

class Movie
{
    use ModelTrait;

    /**
     * @var int
     */
    private $id;
    /**
     * @var string|null
     */
    private $posterPath;
    /**
     * @var string
     */
    private $overview;
    /**
     * @var string
     */
    private $releaseDate;
    /**
     * @var string
     */
    private $title;
    /**
     * @var int
     */
    private $voteCount;
    /**
     * @var float
     */
    private $voteAverage;
    /**
     * @var bool
     */
    private $hasVideo;
    /**
     * @var array
     */
    private $productionCompanies;
    /**
     * @var MovieVideo|null
     */
    private $video;
    /**
     * @var string|null
     */
    private $backdropPath;

    public function __construct(int $id, ?string $posterPath, ?string $backdropPath, string $overview, string $releaseDate, string $title, int $voteCount, float $voteAverage, array $productionCompanies, ?MovieVideo $movieVideo, bool $hasVideo)
    {
        $this->id = $id;
        $this->posterPath = $posterPath;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->title = $title;
        $this->voteCount = $voteCount;
        $this->voteAverage = $voteAverage;
        $this->hasVideo = $hasVideo;
        $this->productionCompanies = $productionCompanies;
        $this->video = $movieVideo;
        $this->backdropPath = $backdropPath;
    }
}