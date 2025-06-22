<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom password error messages
        Validator::replacer('regex', function ($message, $attribute, $rule, $parameters) {
        if ($attribute === 'password') {
            return 'The password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.';
        }
        return $message;
    });
    }
}
