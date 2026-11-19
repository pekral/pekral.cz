<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\GitHub\GetGitHubRepositoryByNameAction;
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

    public function render(GetGitHubRepositoryByNameAction $getGitHubRepositoryByName, GetGitHubRepositoryReadmeAction $getGitHubRepositoryReadme): View
    {
        $repository = $getGitHubRepositoryByName->execute($this->name);

        if (!$repository instanceof RepositoryData) {
            abort(404);
        }

        return view('livewire.guest.project-detail', [
            'readmeHtml' => $getGitHubRepositoryReadme->execute($repository->name),
            'repository' => $repository,
        ]);
    }

}
