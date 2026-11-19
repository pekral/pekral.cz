<?php

declare(strict_types = 1);

use App\Actions\GitHub\GetGitHubRepositoriesAction;
use App\Data\RepositoryData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
});

/**
 * @param array<string, mixed> $overrides
 * @return array<string, mixed>
 */
function gitHubRepositoryPayload(array $overrides = []): array
{
    return array_merge([
        'description' => 'Curated Rector rule set',
        'fork' => false,
        'html_url' => 'https://github.com/pekral/rector-rules',
        'language' => 'PHP',
        'name' => 'rector-rules',
        'stargazers_count' => 2,
        'topics' => ['rector', 'php', 'refactoring', 'static-analysis'],
    ], $overrides);
}

it('maps a github repository and its composer.json into repository data', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([gitHubRepositoryPayload()], 200),
        'raw.githubusercontent.com/pekral/rector-rules/main/composer.json' => Http::response([
            'name' => 'pekral/rector-rules',
            'description' => 'Rector rules for PHP 8.4+',
            'require' => ['php' => '^8.4'],
        ], 200),
    ]);

    $repositories = app(GetGitHubRepositoriesAction::class)->execute();

    expect($repositories)->toHaveCount(1);
    $repository = $repositories->first();
    expect($repository)->toBeInstanceOf(RepositoryData::class);
    assert($repository instanceof RepositoryData);
    expect($repository->name)->toBe('rector-rules')
        ->and($repository->description)->toBe('Curated Rector rule set')
        ->and($repository->url)->toBe('https://github.com/pekral/rector-rules')
        ->and($repository->language)->toBe('PHP')
        ->and($repository->composerName)->toBe('pekral/rector-rules')
        ->and($repository->composerDescription)->toBe('Rector rules for PHP 8.4+')
        ->and($repository->phpVersion)->toBe('8.4')
        ->and($repository->stars)->toBe(2)
        ->and($repository->topics)->toBe(['rector', 'php', 'refactoring'])
        ->and($repository->summary())->toBe('Curated Rector rule set')
        ->and($repository->hasDistinctComposerDescription())->toBeTrue();
});

it('sorts repositories by stars and keeps the github order for equal stars', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            gitHubRepositoryPayload(['name' => 'one-star', 'stargazers_count' => 1]),
            gitHubRepositoryPayload(['name' => 'popular', 'stargazers_count' => 12]),
            gitHubRepositoryPayload(['name' => 'another-one-star', 'stargazers_count' => 1]),
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    $names = app(GetGitHubRepositoriesAction::class)->execute()->map(static fn (RepositoryData $repository): string => $repository->name);

    expect($names->all())->toBe(['popular', 'one-star', 'another-one-star']);
});

it('skips forks, excluded repositories, unnamed items and non-array items', function (): void {
    Config::set('projects.excluded_repositories', ['pekral.cz']);
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            gitHubRepositoryPayload(['name' => 'forked', 'fork' => true]),
            gitHubRepositoryPayload(['name' => 'pekral.cz']),
            gitHubRepositoryPayload(['name' => '']),
            'not-a-repository',
            gitHubRepositoryPayload(['name' => 'visible']),
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    $names = app(GetGitHubRepositoriesAction::class)->execute()->map(static fn (RepositoryData $repository): string => $repository->name);

    expect($names->all())->toBe(['visible']);
});

it('skips a repository that has neither a github nor a composer description', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            gitHubRepositoryPayload(['name' => 'silent', 'description' => null]),
            gitHubRepositoryPayload(['name' => 'composer-only', 'description' => null]),
        ], 200),
        'raw.githubusercontent.com/pekral/silent/*' => Http::response([], 404),
        'raw.githubusercontent.com/pekral/composer-only/main/composer.json' => Http::response(['description' => 'Described in composer.json'], 200),
    ]);

    $repositories = app(GetGitHubRepositoriesAction::class)->execute();

    expect($repositories)->toHaveCount(1);
    $repository = $repositories->first();
    assert($repository instanceof RepositoryData);
    expect($repository->name)->toBe('composer-only')
        ->and($repository->summary())->toBe('Described in composer.json')
        ->and($repository->hasDistinctComposerDescription())->toBeTrue();
});

it('falls back to the master branch composer.json and defaults missing fields', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'legacy',
                'description' => 'Legacy package',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/legacy/main/composer.json' => Http::response([], 404),
        'raw.githubusercontent.com/pekral/legacy/master/composer.json' => Http::response([
            'description' => 'Legacy package',
            'require' => ['php' => 'dev-master'],
        ], 200),
    ]);

    $repository = app(GetGitHubRepositoriesAction::class)->execute()->first();

    assert($repository instanceof RepositoryData);
    expect($repository->url)->toBe('')
        ->and($repository->language)->toBe('Other')
        ->and($repository->phpVersion)->toBe('')
        ->and($repository->stars)->toBe(0)
        ->and($repository->topics)->toBe([])
        ->and($repository->hasDistinctComposerDescription())->toBeFalse();
});

it('ignores a composer.json that is not a json object', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([gitHubRepositoryPayload(['name' => 'odd', 'topics' => ['php', 42]])], 200),
        'raw.githubusercontent.com/pekral/odd/main/composer.json' => Http::response('"just a string"', 200, ['Content-Type' => 'application/json']),
    ]);

    $repository = app(GetGitHubRepositoriesAction::class)->execute()->first();

    assert($repository instanceof RepositoryData);
    expect($repository->composerDescription)->toBe('')
        ->and($repository->phpVersion)->toBe('')
        ->and($repository->topics)->toBe(['php']);
});

it('returns an empty collection when the github api fails or returns no list', function (int $status, string $body): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response($body, $status, ['Content-Type' => 'application/json']),
    ]);

    expect(app(GetGitHubRepositoriesAction::class)->execute())->toBeEmpty();
})->with([
    'scalar body' => [200, '"nope"'],
    'server error' => [500, '[]'],
]);

it('caches the repositories so github is called once', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([gitHubRepositoryPayload()], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    app(GetGitHubRepositoriesAction::class)->execute();
    app(GetGitHubRepositoriesAction::class)->execute();

    Http::assertSentCount(3);
});
