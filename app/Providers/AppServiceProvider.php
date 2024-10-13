<?php

namespace App\Providers;

use App\Lib\BanknoteRepository;
use App\Lib\Interfaces\IBanknoteRepository;
use App\Lib\Interfaces\ITransactionRepository;
use App\Lib\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IBanknoteRepository::class, BanknoteRepository::class);
        $this->app->bind(ITransactionRepository::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
