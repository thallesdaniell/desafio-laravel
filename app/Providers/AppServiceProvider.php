<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::morphMap([
            'User'   => User::class,
            'Phone'  => Phone::class,
            'Client' => Client::class
        ]);
    }
}
