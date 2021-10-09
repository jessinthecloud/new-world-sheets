<?php

namespace App\Providers;

use App\Converters\Concerns\Converter;
use App\Converters\ItemConverter;
use App\Converters\JsonConverter;
use App\Http\Client\DataFetcher;
use App\Http\Client\Fetcher;
use App\Http\Client\NwfFetcher;
use App\Http\Controllers\ConvertController;
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

        $this->app->when(ItemConverter::class)
            ->needs(Converter::class)
            ->give(function () {
                return new JsonConverter();
            });

        $this->app->when(ItemConverter::class)
            ->needs(Fetcher::class)
            ->give(function () {
                return new NwfFetcher();
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
