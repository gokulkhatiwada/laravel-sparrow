<?php


namespace LaraSparrow\Tests;


class TestCase extends \Orchestra\Testbench\TestCase
{

  protected function getPackageProviders($app)
  {
    return [
        \LaraSparrowServiceProvider::class
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    $app['config']->set('database.default','testdb');
    $app['config']->set('database.connections.testdb',[
        'driver'=>'sqlite',
        'database'=>':memory:'
    ]);
  }

}
