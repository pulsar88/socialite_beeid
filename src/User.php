<?php

namespace Fillincode\BeeId;

class User extends \Laravel\Socialite\Two\User
{
    /**
     * Хеш пароля
     */
    public string $pass_hash;
}