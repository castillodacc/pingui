<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        // longitud por defecto de los campos string
        Schema::defaultStringLength(191);
        Carbon::setLocale(config('app.locale'));
        Carbon::setUtf8(true);
        setlocale(LC_TIME, 'Spanish');

        \Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            if (strlen($value) < 50) {return true; }
            $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
            if (in_array($type, $parameters)) {
                return true;
            }
            return false;
        });

        \Validator::replacer('image64', function($message, $attribute, $rule, $parameters) {
            return str_replace(':values',join(",",$parameters),$message);
        });
    }
}
