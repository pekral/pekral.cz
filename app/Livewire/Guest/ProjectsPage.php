<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\GitHub\GetGitHubRepositoriesAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ProjectsPage extends Component
{

    public function render(GetGitHubRepositoriesAction $getGitHubRepositories): View
    {
        $repositories = $getGitHubRepositories->execute();

        return view('livewire.guest.projects-page', [
            'projects' => $repositories,
            'starCount' => $getGitHubRepositories->totalStars($repositories),
        ]);
    }

}
