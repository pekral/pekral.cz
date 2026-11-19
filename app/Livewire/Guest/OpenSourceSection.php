<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use App\Actions\GitHub\GetGitHubRepositoriesAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class OpenSourceSection extends Component
{

    private const int FEATURED_COUNT = 6;

    public function render(GetGitHubRepositoriesAction $getGitHubRepositories): View
    {
        $repositories = $getGitHubRepositories->execute();

        return view('livewire.guest.open-source-section', [
            'repositories' => $repositories->take(self::FEATURED_COUNT),
            'repositoryCount' => $repositories->count(),
            'starCount' => $getGitHubRepositories->totalStars($repositories),
        ]);
    }

}
