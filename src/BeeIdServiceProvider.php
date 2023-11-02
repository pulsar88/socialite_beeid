<?php

namespace Fillincode\BeeId;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;

class BeeIdServiceProvider extends ServiceProvider
{
    /**
     * Make driver
     *
     * @return void
     */
    public function boot()
    {
        $socialite = $this->app->make(Factory::class);

        $socialite->extend('bee_id', function () use ($socialite) {
            return $socialite->buildProvider(Driver::class, config('services.bee_id'));
        });
    }
}