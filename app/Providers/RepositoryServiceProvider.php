<?php

namespace App\Providers;

use App\Interfaces\MembersRepositoryInterface;
use App\Repositories\MembersRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MembersRepositoryInterface::class, MembersRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
