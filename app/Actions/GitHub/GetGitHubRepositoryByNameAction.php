<?php

declare(strict_types = 1);

namespace App\Actions\GitHub;

use App\Data\RepositoryData;
use Pekral\Arch\Action\ArchAction;

final readonly class GetGitHubRepositoryByNameAction implements ArchAction
{

    public function __construct(private GetGitHubRepositoriesAction $getGitHubRepositories)
    {
    }

    public function execute(string $name): ?RepositoryData
    {
        return $this->getGitHubRepositories->execute()->first(static fn (RepositoryData $repository): bool => $repository->name === $name);
    }

}
