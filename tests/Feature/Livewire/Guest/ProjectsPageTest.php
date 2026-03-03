<?php

declare(strict_types = 1);

use App\Livewire\Guest\ProjectsPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function (): void {
    Cache::flush();
});

it('renders projects page component', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'test-repo',
                'description' => 'Test repository',
                'html_url' => 'https://github.com/pekral/test-repo',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertStatus(200);
});

it('displays page title', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('Projects');
});

it('displays back link', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('Back to home')
        ->assertSeeHtml('href="' . route('home') . '"');
});

it('displays projects list from github', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'rector-rules',
                'description' => 'Custom Rector rules',
                'html_url' => 'https://github.com/pekral/rector-rules',
                'language' => 'PHP',
            ],
            [
                'name' => 'arch-app-services',
                'description' => 'Simple architecture',
                'html_url' => 'https://github.com/pekral/arch-app-services',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/rector-rules/main/composer.json' => Http::response([
            'description' => 'Custom Rector rules for PHP',
        ], 200),
        'raw.githubusercontent.com/pekral/arch-app-services/main/composer.json' => Http::response([
            'description' => 'Simple architecture package',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('rector-rules')
        ->assertSee('arch-app-services')
        ->assertSee('Custom Rector rules')
        ->assertSee('Simple architecture');
});

it('displays composer description from composer.json', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'my-package',
                'description' => 'GitHub description',
                'html_url' => 'https://github.com/pekral/my-package',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/my-package/main/composer.json' => Http::response([
            'name' => 'pekral/my-package',
            'description' => 'Composer package description',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('my-package')
        ->assertSee('GitHub description')
        ->assertSee('Composer package description');
});

it('excludes repositories from config projects.excluded_repositories', function (): void {
    Config::set('projects.excluded_repositories', ['toilet-app', 'pekral.cz']);

    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'toilet-app',
                'description' => 'Toilet app',
                'html_url' => 'https://github.com/pekral/toilet-app',
                'language' => 'PHP',
            ],
            [
                'name' => 'pekral.cz',
                'description' => 'Personal website',
                'html_url' => 'https://github.com/pekral/pekral.cz',
                'language' => 'PHP',
            ],
            [
                'name' => 'rector-rules',
                'description' => 'Rector rules',
                'html_url' => 'https://github.com/pekral/rector-rules',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/toilet-app/*' => Http::response(['description' => 'Toilet app'], 200),
        'raw.githubusercontent.com/pekral/pekral.cz/*' => Http::response(['description' => 'Personal site'], 200),
        'raw.githubusercontent.com/pekral/rector-rules/main/composer.json' => Http::response([
            'description' => 'Custom Rector rules',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertDontSee('toilet-app')
        ->assertDontSee('pekral.cz')
        ->assertSee('rector-rules')
        ->assertSee('Custom Rector rules');
});

it('excludes custom repository when set in config', function (): void {
    Config::set('projects.excluded_repositories', ['custom-excluded-repo']);

    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'custom-excluded-repo',
                'description' => 'Excluded via config',
                'html_url' => 'https://github.com/pekral/custom-excluded-repo',
                'language' => 'PHP',
            ],
            [
                'name' => 'visible-repo',
                'description' => 'Visible repo',
                'html_url' => 'https://github.com/pekral/visible-repo',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/custom-excluded-repo/*' => Http::response(['description' => 'Excluded'], 200),
        'raw.githubusercontent.com/pekral/visible-repo/main/composer.json' => Http::response([
            'description' => 'Visible repo description',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertDontSee('custom-excluded-repo')
        ->assertSee('visible-repo')
        ->assertSee('Visible repo description');
});

it('filters out projects without composer description', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'no-composer-repo',
                'description' => 'Repository without composer.json',
                'html_url' => 'https://github.com/pekral/no-composer-repo',
                'language' => 'JavaScript',
            ],
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertStatus(200)
        ->assertDontSee('no-composer-repo');
});

it('tries master branch if main branch fails', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'old-repo',
                'description' => 'Old repository',
                'html_url' => 'https://github.com/pekral/old-repo',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/old-repo/main/composer.json' => Http::response([], 404),
        'raw.githubusercontent.com/pekral/old-repo/master/composer.json' => Http::response([
            'description' => 'Master branch composer description',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('old-repo')
        ->assertSee('Master branch composer description');
});

it('displays github link', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('View all open source PHP projects');
});

it('handles empty repositories list', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertStatus(200)
        ->assertSee('Projects');
});

it('handles github api error gracefully', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([], 500),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertStatus(200)
        ->assertSee('Projects');
});

it('caches repositories', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'cached-repo',
                'description' => 'Cached repository',
                'html_url' => 'https://github.com/pekral/cached-repo',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/cached-repo/main/composer.json' => Http::response([
            'description' => 'Cached composer description',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('cached-repo');

    Livewire::test(ProjectsPage::class)
        ->assertSee('cached-repo');
});

it('displays php version from composer.json', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'php-package',
                'description' => 'PHP package',
                'html_url' => 'https://github.com/pekral/php-package',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/php-package/main/composer.json' => Http::response([
            'description' => 'A PHP package',
            'require' => [
                'php' => '^8.2',
            ],
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('php-package')
        ->assertSee('8.2');
});

it('filters out non-array repository items from github response', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'valid-repo',
                'description' => 'Valid repo',
                'html_url' => 'https://github.com/pekral/valid-repo',
                'language' => 'PHP',
            ],
            'invalid-non-array-item',
        ], 200),
        'raw.githubusercontent.com/pekral/valid-repo/main/composer.json' => Http::response([
            'description' => 'Valid repo description',
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('valid-repo')
        ->assertSee('Valid repo description');
});

it('filters out repos with empty name', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => '',
                'description' => 'No name repo',
                'html_url' => 'https://github.com/pekral/empty',
                'language' => 'PHP',
            ],
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertStatus(200)
        ->assertDontSee('No name repo');
});

it('handles composer php constraint without version pattern', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'no-php-version-repo',
                'description' => 'Repo without parseable PHP version',
                'html_url' => 'https://github.com/pekral/no-php-version-repo',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/pekral/no-php-version-repo/main/composer.json' => Http::response([
            'description' => 'Description only',
            'require' => [
                'php' => 'dev-master',
            ],
        ], 200),
    ]);

    Livewire::test(ProjectsPage::class)
        ->assertSee('no-php-version-repo')
        ->assertSee('Description only');
});
