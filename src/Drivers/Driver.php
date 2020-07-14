<?php

namespace Kings\Press\Drivers;

use Kings\Press\PressFileParser;

abstract class Driver
{
    protected $post = [];
    protected $config;
    public function __construct()
    {
        $this->setConfig();
        $this->validateSource();
    }

    protected function setConfig()
    {
        $drivers = config('press.drivers');
        $driver = config('press.driver');
        $this->config = $drivers[$driver];
        //dd($this->config);
    }

    protected function validateSource()
    {
        return true;
    }

    abstract public function fetchPosts();

    protected function parse($content, $identifier)
    {
        //dd($identifier);
        $this->posts[$identifier] = (new PressFileParser($content))->getData();
    }
}
