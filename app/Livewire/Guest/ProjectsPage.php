<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

final class ProjectsPage extends Component
{
    /**
     * @var array<int, array{
     *     name: string,
     *     description: string,
     *     url: string,
     *     language: string,
     *     composerDescription: string,
     *     phpVersion: string
     * }>
     */
    public array $projects = [];

    public function mount(): void
    {
        $this->projects = $this->fetchRepositories();
    }

    /**
     * @return array<int, array{
     *     name: string,
     *     description: string,
     *     url: string,
     *     language: string,
     *     composerDescription: string,
     *     phpVersion: string
     * }>
     */
    private function fetchRepositories(): array
    {
        return Cache::remember('github_repositories_pekral_v3', 3600 * 24 * 31, function (): array {
            $response = Http::timeout(10)->get('https://api.github.com/users/pekral/repos', [
                'type' => 'public',
                'sort' => 'updated',
                'per_page' => 10,
            ]);

            if (! $response->successful()) {
                return [];
            }

            $repositories = $response->json();

            if (! is_array($repositories)) {
                return [];
            }

            $projects = [];

            foreach ($repositories as $repo) {
                if (! is_array($repo)) {
                    continue;
                }

                $repoName = $repo['name'] ?? '';
                $composerData = $this->fetchComposerData($repoName);

                if ($composerData['description'] === '') {
                    continue;
                }

                $projects[] = [
                    'name' => $repoName,
                    'description' => $repo['description'] ?? '',
                    'url' => $repo['html_url'] ?? '',
                    'language' => $repo['language'] ?? 'Other',
                    'composerDescription' => $composerData['description'],
                    'phpVersion' => $composerData['phpVersion'],
                ];
            }

            return $projects;
        });
    }

    /**
     * @return array{
     *     description: string,
     *     phpVersion: string
     * }
     */
    private function fetchComposerData(string $repoName): array
    {
        $emptyResult = [
            'description' => '',
            'phpVersion' => '',
        ];

        if ($repoName === '') {
            return $emptyResult;
        }

        $response = Http::timeout(5)->get(
            "https://raw.githubusercontent.com/pekral/{$repoName}/main/composer.json"
        );

        if (! $response->successful()) {
            $response = Http::timeout(5)->get(
                "https://raw.githubusercontent.com/pekral/{$repoName}/master/composer.json"
            );
        }

        if (! $response->successful()) {
            return $emptyResult;
        }

        $composerJson = $response->json();

        if (! is_array($composerJson)) {
            return $emptyResult;
        }

        $phpVersion = '';
        $require = $composerJson['require'] ?? [];

        if (is_array($require) && isset($require['php'])) {
            $phpVersion = $this->parsePhpVersion((string) $require['php']);
        }

        return [
            'description' => $composerJson['description'] ?? '',
            'phpVersion' => $phpVersion,
        ];
    }

    private function parsePhpVersion(string $constraint): string
    {
        if (preg_match('/(\d+\.\d+)/', $constraint, $matches)) {
            return $matches[1];
        }

        return '';
    }

    public function render(): View
    {
        return view('livewire.guest.projects-page');
    }
}
