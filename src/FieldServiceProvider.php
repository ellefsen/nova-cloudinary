<?php

namespace Aeon\Cloudinary;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('cloudinary-all', 'https://widget.cloudinary.com/v2.0/global/all.js');
            Nova::script('cloudinary', __DIR__.'/../dist/js/field.js');
            Nova::style('cloudinary', __DIR__.'/../dist/css/field.css');
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
