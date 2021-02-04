<?php

namespace Aankhijhyaal\LaraSparrow;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Aankhijhyaal\LaraSparrow\Channel\SparrowChannel;

class LaraSparrowServiceProvider extends ServiceProvider
{
  public function boot()
  {

    Notification::extend('sparrow',function($app){
      return new SparrowChannel();
    });

    $this->publishes([
        __DIR__.'/config/sparrow.php'=>config_path('sparrow.php')
    ],'lara-sparrow');
  }

  public function register()
  {
  }
}
