<?php

declare(strict_types = 1);

namespace App\Actions\Blog;

use App\Repositories\BlogContentRepository;
use Pekral\Arch\Action\ArchAction;

final readonly class GetBlogImagePathAction implements ArchAction
{

    public function __construct(private BlogContentRepository $blogContentRepository) {}

    public function execute(string $slug): ?string
    {
        return $this->blogContentRepository->getImagePath($slug);
    }

}
