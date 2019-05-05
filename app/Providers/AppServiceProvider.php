<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app['validator']->extend('old_password', function ($attribute, $value, $parameters) {
            return \Hash::check($value, $parameters[0]);
        });

        \View::composer('*', function ($view) {
            $view->with('user', \Auth::user());
        });
    }
}
