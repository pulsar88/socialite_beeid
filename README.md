## Socialite-BeeId

### Installation

```shell
composer require fillincode/bee-id
```

### Get started

1. After installing the package, you need to add data to connect to the authorization service in the config/services.php file

    ```php
    return [
        'bee_id' => [
            'client_id' => env('BEE_ID_CLIENT_ID'),
            'client_secret' => env('BEE_ID_CLIENT_SECRET'),
            'redirect' => env('BEE_ID_REDIRECT_URL'),
        ],
    ];
    ```

2. Add routes for authorization

    ```php
    use Laravel\Socialite\Facades\Socialite;
    
    Route::get('/auth/redirect', function () {
        return Socialite::driver('bee_id')->redirect();
    });
    
    Route::get('/auth/callback', function () {
        $user = Socialite::driver('bee_id')->user();
    
        // $user->token
    });
    ```