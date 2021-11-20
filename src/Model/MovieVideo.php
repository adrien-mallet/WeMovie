<?php


namespace App\Model;


class MovieVideo
{
    use ModelTrait;

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $site;
    /**
     * @var string
     */
    private $key;

    public function __construct(string $id, string $name, string $site, string $key)
    {
        $this->id = $id;
        $this->name = $name;
        $this->site = $site;
        $this->key = $key;
    }
}