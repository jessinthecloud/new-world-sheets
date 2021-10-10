<?php

namespace App\Providers;

use App\Calculators\Concerns\Calculator;
use App\Calculators\LeatherworkingCalculator;
use App\Converters\Concerns\Converter;
use App\Converters\ItemConverter;
use App\Converters\JsonConverter;
use App\Converters\RecipeConverter;
use App\Http\Client\DataFetcher;
use App\Http\Client\Fetcher;
use App\Http\Client\NwfFetcher;
use App\Http\Controllers\CalculateLeatherworkingController;
use App\Http\Controllers\ConvertItemsController;
use App\Http\Controllers\ConvertRecipesController;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\NwfController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(NwfController::class)
            ->needs(Fetcher::class)
            ->give(function () {
                return new NwfFetcher();
            });

        // TODO: move to converter service provider
        $this->app->when(ConvertItemsController::class)
            ->needs(Converter::class)
            ->give(function () {
                return $this->app->makeWith(
                    ItemConverter::class, 
                    [NwfFetcher::class]
                );
            });

        // TODO: move to converter service provider
        $this->app->when(ConvertRecipesController::class)
            ->needs(Converter::class)
            ->give(function () {
                return $this->app->makeWith(
                    RecipeConverter::class,
                    [NwfFetcher::class]
                );
            });

        // TODO: move to converter service provider
        $this->app->when([ItemConverter::class, RecipeConverter::class])
            ->needs(Fetcher::class)
            ->give(function () {
                return new NwfFetcher();
            });
        
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
