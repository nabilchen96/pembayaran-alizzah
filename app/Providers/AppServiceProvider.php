<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider 
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
<<<<<<< HEAD
        Schema::defaultStringLength(191);
=======
        // if(env('APP_ENV') !== 'local'){
        //     URL::forceScheme('https');
        // }
>>>>>>> 0436d400e954103caf152a0dc46077409c0206f0
    }
}
