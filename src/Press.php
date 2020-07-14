<?php

namespace Kings\Press;

class Press
{
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
}
