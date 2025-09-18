<?php

namespace App\Providers;

use App\Http\Repositories\Contracts\IMessageRepository;
use App\Http\Repositories\MessageRepository;
use App\Http\Services\Contracts\ICacheService;
use App\Http\Services\Contracts\IMessageService;
use App\Http\Services\MessageService;
use App\Http\Services\RedisCacheService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ICacheService::class, RedisCacheService::class);
        $this->app->bind(IMessageService::class, MessageService::class);
        $this->app->bind(IMessageRepository::class, MessageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
