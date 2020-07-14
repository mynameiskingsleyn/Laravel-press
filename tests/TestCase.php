<?php

namespace Kings\Press\Tests;

use Kings\Press\PressBaseServiceProvider;
use Orchestra\Testbench\Concerns\WithFactories;
use Orchestra\Testbench\TestCase as BaseCase;

//use Illuminate\Foundation\Testing\TestCase as BaseCase;

abstract class TestCase extends BaseCase
{
    //use CreatesApplication;
    //use WithFactories;
    protected function setUp() : void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->withFactories(__DIR__.'/../database/factories');

        // $this->withFactories('');
    }
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PressBaseServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //parent::getEnvironmentSetUp($app); // TODO: Change the autogenerated stub
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
