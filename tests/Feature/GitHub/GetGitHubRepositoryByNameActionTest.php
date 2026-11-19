<?php

declare(strict_types = 1);

use App\Actions\GitHub\GetGitHubRepositoryByNameAction;
use App\Data\RepositoryData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            ['name' => 'rector-rules', 'description' => 'Curated Rector rule set'],
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);
});

it('finds a repository by its exact name', function (): void {
    $repository = app(GetGitHubRepositoryByNameAction::class)->execute('rector-rules');

    expect($repository)->toBeInstanceOf(RepositoryData::class);
    assert($repository instanceof RepositoryData);
    expect($repository->name)->toBe('rector-rules');
});

it('returns null for a name that is not a listed repository', function (): void {
    expect(app(GetGitHubRepositoryByNameAction::class)->execute('rector'))->toBeNull();
});
