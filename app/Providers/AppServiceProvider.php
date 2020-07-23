<?php

namespace App\Providers;

use App\Contracts\RegistrarInterface;
use App\Services\Registrar;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegistrarInterface::class, Registrar::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        JsonResource::withoutWrapping();
    }
}
