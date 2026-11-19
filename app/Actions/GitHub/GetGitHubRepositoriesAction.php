<?php

declare(strict_types = 1);

namespace App\Actions\GitHub;

use App\Data\RepositoryData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Pekral\Arch\Action\ArchAction;

final readonly class GetGitHubRepositoriesAction implements ArchAction
{

    private const string CACHE_KEY = 'github_repositories_pekral_v5';

    private const int CACHE_TTL_SECONDS = 3_600 * 24;

    private const string REPOSITORIES_URL = 'https://api.github.com/users/pekral/repos';

    private const string COMPOSER_JSON_URL = 'https://raw.githubusercontent.com/pekral/%s/%s/composer.json';

    private const int REPOSITORIES_PER_PAGE = 50;

    private const int MAX_TOPICS = 3;

    /**
     * @return \Illuminate\Support\Collection<int, \App\Data\RepositoryData>
     */
    public function execute(): Collection
    {
        /** @var list<array{name: string, description: string, url: string, language: string, composerDescription: string, phpVersion: string, stars: int, topics: list<string>}> $cached */
        $cached = Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL_SECONDS,
            fn (): array => $this->fetchRepositories()->map(static fn (RepositoryData $repository): array => $repository->toArray())->all(),
        );

        return collect($cached)->map(static fn (array $repository): RepositoryData => RepositoryData::fromArray($repository));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\Data\RepositoryData>
     */
    private function fetchRepositories(): Collection
    {
        $response = Http::timeout(10)->get(self::REPOSITORIES_URL, [
            'per_page' => self::REPOSITORIES_PER_PAGE,
            'sort' => 'updated',
            'type' => 'owner',
        ]);
        $repositories = $response->successful() ? $response->json() : [];
        $projects = [];

        foreach (is_array($repositories) ? $repositories : [] as $repository) {
            $project = $this->toRepositoryData($repository);

            if ($project instanceof RepositoryData) {
                $projects[] = $project;
            }
        }

        return collect($projects)
            ->sortByDesc(static fn (RepositoryData $repository): int => $repository->stars)
            ->values();
    }

    private function toRepositoryData(mixed $repository): ?RepositoryData
    {
        if (!is_array($repository)) {
            return null;
        }

        $name = is_string($repository['name'] ?? null) ? $repository['name'] : '';

        if (blank($name) || ($repository['fork'] ?? false) === true || $this->isExcluded($name)) {
            return null;
        }

        $composerJson = $this->fetchComposerJson($name);
        $description = is_string($repository['description'] ?? null) ? $repository['description'] : '';
        $composerDescription = is_string($composerJson['description'] ?? null) ? $composerJson['description'] : '';

        if (blank($description) && blank($composerDescription)) {
            return null;
        }

        return new RepositoryData(
            name: $name,
            description: $description,
            url: is_string($repository['html_url'] ?? null) ? $repository['html_url'] : '',
            language: is_string($repository['language'] ?? null) ? $repository['language'] : 'Other',
            composerDescription: $composerDescription,
            phpVersion: $this->extractPhpVersion($composerJson),
            stars: is_int($repository['stargazers_count'] ?? null) ? $repository['stargazers_count'] : 0,
            topics: $this->extractTopics($repository),
        );
    }

    private function isExcluded(string $name): bool
    {
        return in_array($name, Config::array('projects.excluded_repositories', []), strict: true);
    }

    /**
     * @return array<mixed>
     */
    private function fetchComposerJson(string $name): array
    {
        foreach (['main', 'master'] as $branch) {
            $response = Http::timeout(5)->get(sprintf(self::COMPOSER_JSON_URL, $name, $branch));

            if ($response->successful()) {
                $json = $response->json();

                return is_array($json) ? $json : [];
            }
        }

        return [];
    }

    /**
     * @param array<mixed> $composerJson
     */
    private function extractPhpVersion(array $composerJson): string
    {
        $constraint = is_array($composerJson['require'] ?? null) ? $composerJson['require']['php'] ?? null : null;

        if (is_string($constraint) && preg_match('/(\d+\.\d+)/', $constraint, $matches) === 1) {
            return $matches[1];
        }

        return '';
    }

    /**
     * @param array<mixed> $repository
     * @return list<string>
     */
    private function extractTopics(array $repository): array
    {
        $topics = is_array($repository['topics'] ?? null) ? $repository['topics'] : [];

        return array_slice(array_values(array_filter($topics, is_string(...))), 0, self::MAX_TOPICS);
    }

}
