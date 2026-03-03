<?php

declare(strict_types = 1);

namespace App\Actions\Blog;

use App\Data\ArticleData;
use App\Repositories\BlogContentRepository;
use Pekral\Arch\Action\ArchAction;

final readonly class GetBlogArticleBySlugAction implements ArchAction
{

    public function __construct(private BlogContentRepository $blogContentRepository) {}

    public function execute(string $slug): ?ArticleData
    {
        return $this->blogContentRepository->getBySlug($slug);
    }

}
