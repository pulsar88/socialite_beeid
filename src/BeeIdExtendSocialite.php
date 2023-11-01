<?php

namespace Fillicode\BeeId;

use Illuminate\Support\Facades\App;
use Laravel\Socialite\Contracts\Factory;

class BeeIdExtendSocialite
{
    /**
     * driver connection
     *
     * @return void
     */
    public static function init(): void
    {
        $socialite = App::make(Factory::class);

        $socialite->extend('bee_id', function () use ($socialite) {
            return $socialite->buildProvider(Provider::class, config('services.bee_id'));
        });
    }
}
