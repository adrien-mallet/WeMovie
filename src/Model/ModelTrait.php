<?php


namespace App\Model;


trait ModelTrait
{
    public function __get($name)
    {
        $this->propertyCheck($name);

        return $this->$name;
    }

    public function __call($name, array $arguments)
    {
        $attributeName = lcfirst(str_replace('get', '', $name));
        $this->propertyCheck($attributeName);

        return $this->$attributeName;

    }

    protected function propertyCheck($name)
    {
        if (!property_exists($this, $name))
        {
            throw new \RuntimeException(sprintf('This %s property does not exist for %s', $name, __CLASS__));
        }
    }
}