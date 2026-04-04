<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Repositories\BlogContentRepository;
use Illuminate\Pagination\Paginator;
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
            BlogContentRepository::class,
            static fn (): BlogContentRepository => new BlogContentRepository(is_string($contentPath) ? $contentPath : base_path('content/blog')),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');
        Paginator::defaultSimpleView('pagination::simple-tailwind');
    }

}
