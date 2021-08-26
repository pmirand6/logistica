<?php

namespace App\Providers;

use App\Http\Middleware\Auth0Middleware;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;


use Auth0\Login\Contract\Auth0UserRepository as Auth0UserRepositoryContract;
use Auth0\Login\Repository\Auth0UserRepository as Auth0UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');

    }
}
