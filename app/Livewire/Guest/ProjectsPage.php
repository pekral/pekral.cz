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

    public function render(): View
    {
        return view('livewire.guest.projects-page');
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
            $repositories = $this->fetchGitHubRepositories();

            return $this->mapRepositoriesToProjects($repositories);
        });
    }

    /**
     * @return list<mixed>
     */
    private function fetchGitHubRepositories(): array
    {
        $response = Http::timeout(10)->get('https://api.github.com/users/pekral/repos', [
            'per_page' => 10,
            'sort' => 'updated',
            'type' => 'public',
        ]);

        if (! $response->successful()) {
            return [];
        }

        $repositories = $response->json();

        return is_array($repositories) ? array_values($repositories) : [];
    }

    /**
     * @param  list<mixed>  $repositories
     * @return array<int, array{
     *     name: string,
     *     description: string,
     *     url: string,
     *     language: string,
     *     composerDescription: string,
     *     phpVersion: string
     * }>
     */
    private function mapRepositoriesToProjects(array $repositories): array
    {
        $projects = [];

        foreach ($repositories as $repo) {
            $project = $this->mapRepositoryToProject($repo);

            if ($project !== null) {
                $projects[] = $project;
            }
        }

        return $projects;
    }

    /**
     * @return array{
     *     name: string,
     *     description: string,
     *     url: string,
     *     language: string,
     *     composerDescription: string,
     *     phpVersion: string
     * }|null
     */
    private function mapRepositoryToProject(mixed $repo): ?array
    {
        if (! is_array($repo)) {
            return null;
        }

        $repoName = is_string($repo['name'] ?? null) ? $repo['name'] : '';
        $composerData = $this->fetchComposerData($repoName);

        if ($composerData['description'] === '') {
            return null;
        }

        return [
            'composerDescription' => $composerData['description'],
            'description' => is_string($repo['description'] ?? null) ? $repo['description'] : '',
            'language' => is_string($repo['language'] ?? null) ? $repo['language'] : 'Other',
            'name' => $repoName,
            'phpVersion' => $composerData['phpVersion'],
            'url' => is_string($repo['html_url'] ?? null) ? $repo['html_url'] : '',
        ];
    }

    /**
     * @return array{description: string, phpVersion: string}
     */
    private function fetchComposerData(string $repoName): array
    {
        $emptyResult = ['description' => '', 'phpVersion' => ''];

        if ($repoName === '') {
            return $emptyResult;
        }

        $composerJson = $this->fetchComposerJson($repoName);

        if ($composerJson === null) {
            return $emptyResult;
        }

        $description = $composerJson['description'] ?? '';

        return [
            'description' => is_string($description) ? $description : '',
            'phpVersion' => $this->extractPhpVersion($composerJson),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function fetchComposerJson(string $repoName): ?array
    {
        $branches = ['main', 'master'];

        foreach ($branches as $branch) {
            $url = sprintf('https://raw.githubusercontent.com/pekral/%s/%s/composer.json', $repoName, $branch);
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                /** @var array<string, mixed>|null $json */
                $json = $response->json();

                return is_array($json) ? $json : null;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $composerJson
     */
    private function extractPhpVersion(array $composerJson): string
    {
        $require = $composerJson['require'] ?? [];

        if (is_array($require) && isset($require['php']) && is_string($require['php'])) {
            return $this->parsePhpVersion($require['php']);
        }

        return '';
    }

    private function parsePhpVersion(string $constraint): string
    {
        if (preg_match('/(\d+\.\d+)/', $constraint, $matches)) {
            return $matches[1];
        }

        return '';
    }
}
