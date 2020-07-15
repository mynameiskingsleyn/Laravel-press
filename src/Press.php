<?php

namespace Kings\Press;

class Press
{
    protected $fields = [];
    protected $registeredFields =[];
    public function configNotPublished()
    {
        return is_null(config('press'));
    }

    public function driver()
    {
        $driver = ucfirst(config('press.driver'));
        //dd($driver);
        $class = 'Kings\Press\Drivers\\'.$driver.'Driver'; // kings/Press/Drivers/Driver
        return new $class;
    }

    public function path()
    {
        return config('press.path', 'blogs');
    }

    public function fields(array $fields)
    {
        $temp = array_map([$this,'getName'], $fields);
        $this->registeredFields = array_merge($this->registeredFields, $temp);
        $this->fields = array_merge($this->fields, $fields);
    }

    public function availableFields()
    {
        return array_reverse($this->fields);
    }

    public function getRegisteredFields()
    {
        return $this->registeredFields;
    }

    public function getName($class)
    {
        $c = new \ReflectionClass($class);
        return strtolower($c->getShortName());
    }
}
