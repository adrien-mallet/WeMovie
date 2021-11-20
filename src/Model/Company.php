<?php


namespace App\Model;


class Company
{
    use ModelTrait;

    private $id;
    private $name;

    /**
     * Company constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}