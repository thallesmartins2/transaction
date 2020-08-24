<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\TransactionRepository;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(TransactionRepositoryInterface::class, function ($app) {             
            return new TransactionRepository;         
        });
    }
}
