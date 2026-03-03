<?php

declare(strict_types = 1);

namespace App\Actions\Blog;

use App\Repositories\BlogContentRepository;
use Illuminate\Support\Collection;
use Pekral\Arch\Action\ArchAction;

final readonly class GetAllBlogArticlesAction implements ArchAction
{

    public function __construct(private BlogContentRepository $blogContentRepository) {}

    /**
     * @return \Illuminate\Support\Collection<int, \App\Data\ArticleData>
     */
    public function execute(): Collection
    {
        return $this->blogContentRepository->getAll();
    }

}
