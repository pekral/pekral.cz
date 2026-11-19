<?php

declare(strict_types = 1);

namespace App\Actions\GitHub;

use App\Data\RepositoryData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Pekral\Arch\Action\ArchAction;

/**
 * @phpstan-import-type RepositoryArray from \App\Data\RepositoryData
 */
final readonly class GetGitHubRepositoriesAction implements ArchAction
{

    private const string CACHE_KEY = 'github_repositories_pekral_v6';

    private const int CACHE_TTL_SECONDS = 3_600 * 4;

    private const string FAILURE_CACHE_KEY = 'github_repositories_failed';

    private const int FAILURE_TTL_SECONDS = 600;

    private const string REPOSITORIES_URL = 'https://api.github.com/users/pekral/repos';

    private const string COMPOSER_JSON_URL = 'https://raw.githubusercontent.com/pekral/%s/%s/composer.json';

    private const int REPOSITORIES_PER_PAGE = 50;

    private const int MAX_TOPICS = 3;

    /**
     * @return \Illuminate\Support\Collection<int, \App\Data\RepositoryData>
     */
    public function execute(): Collection
    {
        $cached = Cache::get(self::CACHE_KEY);

        if (!is_array($cached)) {
            $cached = $this->loadRepositories();
        }

        /** @var list<RepositoryArray> $cached */
        return collect($cached)->map(static fn (array $repository): RepositoryData => RepositoryData::fromArray($repository));
    }

    /**
     * @param \Illuminate\Support\Collection<int, \App\Data\RepositoryData> $repositories
     */
    public function totalStars(Collection $repositories): int
    {
        return (int) $repositories->sum(static fn (RepositoryData $repository): int => $repository->stars);
    }

    /**
     * @return list<RepositoryArray>
     */
    private function loadRepositories(): array
    {
        if (Cache::has(self::FAILURE_CACHE_KEY)) {
            return [];
        }

        $repositories = $this->fetchRepositories();

        if (!$repositories instanceof Collection) {
            Cache::put(self::FAILURE_CACHE_KEY, value: true, ttl: self::FAILURE_TTL_SECONDS);

            return [];
        }

        $cached = array_values($repositories->map(static fn (RepositoryData $repository): array => $repository->toArray())->all());
        Cache::put(self::CACHE_KEY, $cached, self::CACHE_TTL_SECONDS);

        return $cached;
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\Data\RepositoryData>|null
     */
    private function fetchRepositories(): ?Collection
    {
        try {
            $response = Http::timeout(10)->get(self::REPOSITORIES_URL, [
                'per_page' => self::REPOSITORIES_PER_PAGE,
                'sort' => 'updated',
                'type' => 'owner',
            ]);
        } catch (ConnectionException) {
            return null;
        }

        $repositories = $response->successful() ? $response->json() : null;

        if (!is_array($repositories)) {
            return null;
        }

        $projects = [];

        foreach ($repositories as $repository) {
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

        $name = $this->stringValue($repository, 'name');

        if ($this->isSkipped($repository, $name)) {
            return null;
        }

        $composerJson = $this->fetchComposerJson($name);
        $description = $this->stringValue($repository, 'description');
        $composerDescription = $this->stringValue($composerJson, 'description');

        if (blank($description) && blank($composerDescription)) {
            return null;
        }

        return new RepositoryData(
            name: $name,
            description: $description,
            url: $this->stringValue($repository, 'html_url'),
            language: $this->stringValue($repository, 'language', 'Other'),
            composerName: $this->stringValue($composerJson, 'name'),
            composerDescription: $composerDescription,
            phpVersion: $this->extractPhpVersion($composerJson),
            stars: $this->stars($repository),
            topics: $this->extractTopics($repository),
        );
    }

    /**
     * @param array<mixed> $repository
     */
    private function isSkipped(array $repository, string $name): bool
    {
        return blank($name) || ($repository['fork'] ?? false) === true || $this->isExcluded($name);
    }

    /**
     * @param array<mixed> $values
     */
    private function stringValue(array $values, string $key, string $default = ''): string
    {
        $value = $values[$key] ?? null;

        return is_string($value) ? $value : $default;
    }

    /**
     * @param array<mixed> $repository
     */
    private function stars(array $repository): int
    {
        $stars = $repository['stargazers_count'] ?? null;

        return is_int($stars) ? $stars : 0;
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
            try {
                $response = Http::timeout(5)->get(sprintf(self::COMPOSER_JSON_URL, $name, $branch));
            } catch (ConnectionException) {
                continue;
            }

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
