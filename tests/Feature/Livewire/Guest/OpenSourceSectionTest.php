<?php

declare(strict_types = 1);

use App\Livewire\Guest\OpenSourceSection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function (): void {
    Cache::flush();
});

/**
 * @return array<string, mixed>
 */
function openSourceRepository(string $name, int $stars): array
{
    return [
        'description' => sprintf('%s description', $name),
        'html_url' => sprintf('https://github.com/pekral/%s', $name),
        'language' => 'PHP',
        'name' => $name,
        'stargazers_count' => $stars,
        'topics' => ['laravel'],
    ];
}

it('shows at most six repositories with the total counts', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response(
            collect(range(1, 7))->map(static fn (int $index): array => openSourceRepository(sprintf('repo-%d', $index), $index))->all(),
            200,
        ),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(OpenSourceSection::class);
    $component->assertStatus(200);
    $component->assertSee('Open Source PHP Projects');
    $component->assertSee('7 repositories');
    $component->assertSee('28 stars');
    $component->assertSee('repo-7');
    $component->assertSee('repo-2');
    $component->assertDontSee('repo-1 description');
    $component->assertSee('#laravel');
    $component->assertSeeHtml('href="' . route('projects.show', 'repo-7') . '"');
    $component->assertSeeHtml('src="' . route('projects.social-image', 'repo-7') . '"');
    $component->assertSeeHtml('href="' . route('projects') . '"');
});

it('shows a github fallback when no repository could be loaded', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([], 500),
    ]);

    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test(OpenSourceSection::class);
    $component->assertStatus(200);
    $component->assertSee('could not be loaded');
    $component->assertDontSee('★');
    $component->assertSeeHtml('href="https://github.com/pekral"');
});
