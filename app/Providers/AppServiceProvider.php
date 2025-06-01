<?php

namespace App\Providers;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;
use App\Models\PersonalAccessToken; 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
           //Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
   
    }}
