<?php

namespace App\Providers;

use App\Microservices\EmailTransport;
use Illuminate\Support\ServiceProvider;
use Mail;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Mail::extend('maxim', function (array $mail) {
            return new EmailTransport(
                $mail['host'],
                $mail['port'],
            );
        });
    }
}
