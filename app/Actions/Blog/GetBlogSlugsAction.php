<?php

declare(strict_types = 1);

namespace App\Actions\Blog;

use App\Repositories\BlogContentRepository;
use Pekral\Arch\Action\ArchAction;

final readonly class GetBlogSlugsAction implements ArchAction
{

    public function __construct(private BlogContentRepository $blogContentRepository) {}

    /**
     * @return array<int, string>
     */
    public function execute(): array
    {
        return $this->blogContentRepository->getSlugs();
    }

}
