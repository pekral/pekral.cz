<?php

declare(strict_types = 1);

use App\Actions\GitHub\GetGitHubRepositoryReadmeAction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
});

it('renders github flavoured markdown, strips raw html and resolves relative links', function (): void {
    Http::fake([
        'raw.githubusercontent.com/pekral/demo/HEAD/README.md' => Http::response(implode("\n", [
            '# Demo',
            '',
            'Install with `composer require pekral/demo`.',
            '',
            '| Rule | Level |',
            '|------|-------|',
            '| A    | 1     |',
            '',
            '- [x] done',
            '',
            '![logo](docs/logo.png) [docs](./docs/index.md) [anchor](#demo) [site](https://pekral.cz) [proto](//cdn.example.com/x.png)',
            '',
            '<script>alert(1)</script><img src="x" onerror="alert(1)">',
            '',
            '[evil](javascript:alert(1))',
        ]), 200),
    ]);

    $html = app(GetGitHubRepositoryReadmeAction::class)->execute('demo');

    expect($html)->toBeString();
    assert(is_string($html));
    expect($html)->toContain('<table>')
        ->toContain('<code>composer require pekral/demo</code>')
        ->toContain('src="https://raw.githubusercontent.com/pekral/demo/HEAD/docs/logo.png"')
        ->toContain('href="https://github.com/pekral/demo/blob/HEAD/docs/index.md"')
        ->toContain('href="#demo"')
        ->toContain('href="https://pekral.cz"')
        ->toContain('href="//cdn.example.com/x.png"')
        ->toContain('type="checkbox"');
    expect($html)->not->toContain('<script');
    expect($html)->not->toContain('onerror');
    expect($html)->not->toContain('javascript:');
});

it('returns null when the readme is missing or empty and caches the answer', function (int $status, string $body): void {
    Http::fake([
        'raw.githubusercontent.com/pekral/empty/HEAD/README.md' => Http::response($body, $status),
    ]);

    expect(app(GetGitHubRepositoryReadmeAction::class)->execute('empty'))->toBeNull();
    expect(app(GetGitHubRepositoryReadmeAction::class)->execute('empty'))->toBeNull();

    Http::assertSentCount(1);
})->with([
    'blank file' => [200, "  \n"],
    'not found' => [404, 'Not Found'],
]);

it('keeps dot directories intact while resolving relative paths', function (string $path, string $expected): void {
    Http::fake([
        'raw.githubusercontent.com/pekral/demo/HEAD/README.md' => Http::response('![banner](' . $path . ')', 200),
    ]);

    $html = app(GetGitHubRepositoryReadmeAction::class)->execute('demo');

    expect($html)->toContain('src="https://raw.githubusercontent.com/pekral/demo/HEAD/' . $expected . '"');
})->with([
    'current directory prefix' => ['./docs/logo.png', 'docs/logo.png'],
    'dot directory' => ['.github/banner.png', '.github/banner.png'],
    'root prefix' => ['/docs/logo.png', 'docs/logo.png'],
]);

it('returns null when github cannot be reached', function (): void {
    Http::fake(Http::failedConnection('timeout'));

    expect(app(GetGitHubRepositoryReadmeAction::class)->execute('demo'))->toBeNull();
});
