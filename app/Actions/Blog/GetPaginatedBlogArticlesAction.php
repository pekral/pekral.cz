<?php

declare(strict_types = 1);

namespace App\Actions\Blog;

use App\Repositories\BlogContentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginatorConcrete;
use Pekral\Arch\Action\ArchAction;

final readonly class GetPaginatedBlogArticlesAction implements ArchAction
{

    public function __construct(private BlogContentRepository $blogContentRepository) {}

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, \App\Data\ArticleData>
     */
    public function execute(?int $page = null): LengthAwarePaginator
    {
        $all = $this->blogContentRepository->getAll();
        $perPageRaw = config('blog.articles_per_page', 10);
        $perPage = is_int($perPageRaw) ? $perPageRaw : (int) (is_numeric($perPageRaw) ? $perPageRaw : 10);
        $perPage = max(1, $perPage);
        $page = max(1, $page ?? request()->integer('page', 1));

        return new LengthAwarePaginatorConcrete(
            $all->forPage($page, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()],
        );
    }

}
