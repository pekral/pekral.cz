<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\GitHub\GetGitHubRepositoriesAction;
use App\Actions\GitHub\GetGitHubRepositoryReadmeAction;
use App\Data\RepositoryData;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ProjectDetail extends Component
{

    public string $name;

    public function mount(string $name): void
    {
        $this->name = $name;
    }

    public function render(GetGitHubRepositoriesAction $getGitHubRepositories, GetGitHubRepositoryReadmeAction $getGitHubRepositoryReadme): View
    {
        $repository = $getGitHubRepositories->execute()->first(fn (RepositoryData $repository): bool => $repository->name === $this->name);

        if ($repository === null) {
            abort(404);
        }

        return view('livewire.guest.project-detail', [
            'readmeHtml' => $getGitHubRepositoryReadme->execute($repository->name),
            'repository' => $repository,
        ]);
    }

}
