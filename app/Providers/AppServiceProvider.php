<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Services\BlogService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $contentPath = config('blog.content_path');
        $this->app->singleton(
            BlogService::class,
            fn (): BlogService => new BlogService(is_string($contentPath) ? $contentPath : base_path('content/blog')),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // No bootstrapping needed
    }

}
