<?php

declare(strict_types = 1);

use App\Livewire\Guest\ProjectDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function (): void {
    Cache::flush();
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'rector-rules',
                'description' => 'Curated Rector rule set',
                'html_url' => 'https://github.com/pekral/rector-rules',
                'language' => 'PHP',
                'stargazers_count' => 2,
                'topics' => ['rector'],
            ],
            [
                'name' => 'plain-repo',
                'description' => 'No composer here',
                'html_url' => 'https://github.com/pekral/plain-repo',
                'language' => 'Shell',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/rector-rules/main/composer.json' => Http::response([
            'name' => 'pekral/rector-rules',
            'description' => 'Rector rules for PHP 8.4+',
            'require' => ['php' => '^8.4'],
        ], 200),
        'raw.githubusercontent.com/pekral/rector-rules/HEAD/README.md' => Http::response(
            "# rector-rules\n\n## Installation\n\nRun `composer require --dev pekral/rector-rules`.",
            200,
        ),
        'raw.githubusercontent.com/pekral/plain-repo/*' => Http::response([], 404),
    ]);
});

test('project page shows the repository, its install command and the rendered readme', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/projects/rector-rules');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('<title>rector-rules | Open source project | Petr Král</title>', escape: false);
    $response->assertSee('Curated Rector rule set');
    $response->assertSee('composer require pekral/rector-rules');
    $response->assertSee('2 stars');
    $response->assertSee('#rector');
    $response->assertSee('php ≥ 8.4');
    $response->assertSee('<h2>Installation</h2>', escape: false);
    $response->assertSee('composer require --dev pekral/rector-rules');
    $response->assertSee('href="https://github.com/pekral/rector-rules"', escape: false);
    $response->assertSee('"@type": "SoftwareSourceCode"', escape: false);
    $response->assertSee('"codeRepository": "https://github.com/pekral/rector-rules"', escape: false);
    $response->assertSee('"position": 3', escape: false);
    $response->assertSee('<meta property="og:image" content="' . route('projects.social-image', 'rector-rules') . '">', escape: false);
});

test('project page without composer.json offers a clone command and a readme fallback', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/projects/plain-repo');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('git clone https://github.com/pekral/plain-repo.git');
    $response->assertSee('The README could not be loaded right now.');
});

test('project page returns 404 for an unknown or malformed repository name', function (string $path): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get($path);
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertNotFound();
})->with([
    'malformed' => ['/projects/..%2Fetc'],
    'unknown' => ['/projects/does-not-exist'],
]);

test('sitemap lists the project pages', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get('/sitemap.xml');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertSee('<loc>' . url('/projects/rector-rules') . '</loc>', escape: false);
});

test('project detail component aborts with 404 when the repository is not in the github list', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(ProjectDetail::class, ['name' => 'does-not-exist']);
    $component->assertStatus(404);
});
