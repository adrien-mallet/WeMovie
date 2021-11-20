<?php

namespace App\Model;

class MovieGenre
{
    use ModelTrait;

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}