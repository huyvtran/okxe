<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.index', function($view){
            $view->with('jsLang',json_encode(trans('javascript')));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
