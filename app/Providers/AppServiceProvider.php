<?php

namespace App\Providers;

use App\Calculators\Concerns\Calculator;
use App\Calculators\LeatherworkingCalculator;
use App\Http\Controllers\CalculateLeatherworkingController;
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
        // TODO: move to calculator service provider
        $this->app->when(CalculateLeatherworkingController::class)
            ->needs(Calculator::class)
            ->give(function () {
                return $this->app->makeWith(
                    LeatherworkingCalculator::class,
                    []
                );
            });

        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
