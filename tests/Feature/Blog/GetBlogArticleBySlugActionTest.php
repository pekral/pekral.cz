<?php

declare(strict_types = 1);

use App\Actions\Blog\GetBlogArticleBySlugAction;
use App\Data\ArticleData;
use App\Repositories\BlogContentRepository;
use Carbon\Carbon;

test('returns article data for existing slug', function (): void {
    $action = app(GetBlogArticleBySlugAction::class);
    $article = $action->execute('vibe-coding-with-ai-good-servant-bad-master');

    expect($article)->toBeInstanceOf(ArticleData::class);
    assert($article instanceof ArticleData);
    expect($article->slug)->toBe('vibe-coding-with-ai-good-servant-bad-master');
    expect($article->title)->toContain('Vibe coding with AI');
    expect($article->description)->not->toBeEmpty();
    expect($article->htmlContent)->toContain('<h1>');
    expect($article->date)->not->toBeNull();
    expect($article->hasImage)->toBeTrue();
    expect($article->readingTimeMinutes)->toBeGreaterThan(0);
});

test('returns null for non-existent slug', function (): void {
    $action = app(GetBlogArticleBySlugAction::class);
    expect($action->execute('non-existent-slug-xyz'))->toBeNull();
});

test('returns null for invalid slug with path traversal', function (): void {
    $action = app(GetBlogArticleBySlugAction::class);
    expect($action->execute('../etc/passwd'))->toBeNull();
    expect($action->execute('foo/bar'))->toBeNull();
});

test('parses article without front matter', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-front-matter';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "Plain text\n\n# Title From Content");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->title)->toBe('Title From Content');
        expect($article->description)->toBe('');
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('uses slug as title when article has no h1', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-h1-heading';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: D\n---\nJust paragraph.");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->title)->toBe($slug);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('parses numeric date from front matter', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'timestamp-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 1609459200\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->date->format('Y-m-d'))->toBe('2021-01-01');
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('uses default date for invalid date in front matter', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'invalid-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: not-a-date\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->date)->toBeInstanceOf(Carbon::class);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('uses default date when front matter date is non-scalar', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'array-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: []\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->date)->toBeInstanceOf(Carbon::class);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('returns 1 minute reading time when content has no words', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-words-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: D\n---\n\n");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->readingTimeMinutes)->toBe(1);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('uses default WPM when config reading_words_per_minute is non-numeric', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'wpm-config-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    $body = str_repeat('word ', 400) . 'end';
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: D\n---\n# Title\n\n" . $body);

    try {
        config(['blog.reading_words_per_minute' => 'invalid']);
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        $article = $action->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->readingTimeMinutes)->toBeGreaterThanOrEqual(1);
    } finally {
        config(['blog.reading_words_per_minute' => 200]);
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('returns null when article path is a directory', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'dir-as-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    mkdir($articleDir . '/article.md', 0755);

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogArticleBySlugAction($repository);
        expect($action->execute($slug))->toBeNull();
    } finally {
        rmdir($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('returns null when file_get_contents fails', function (): void {
    $protocol = 'blogreadfail' . uniqid();
    stream_wrapper_register($protocol, BlogReadFailStreamWrapper::class);

    try {
        $contentPath = $protocol . '://base';
        $repository = new BlogContentRepository($contentPath);
        $action = new GetBlogArticleBySlugAction($repository);
        $previous = set_error_handler(static fn (): bool => true);

        try {
            expect($action->execute('slug'))->toBeNull();
        } finally {
            set_error_handler($previous);
        }
    } finally {
        stream_wrapper_unregister($protocol);
    }
});

test('parseDate returns Carbon instance when value is DateTimeInterface', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'datetime-interface-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-06-15\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $parseDate = new ReflectionMethod($repository, 'parseDate');
        $date = new DateTimeImmutable('2022-03-10 12:00:00');
        $result = $parseDate->invoke($repository, $date);
        expect($result)->toBeInstanceOf(Carbon::class);
        assert($result instanceof Carbon);
        expect($result->format('Y-m-d H:i:s'))->toBe('2022-03-10 12:00:00');
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

/**
 * Stream wrapper for tests: makes file appear readable but file_get_contents fails.
 * Method names and signatures are imposed by PHP's stream wrapper protocol.
 *
 * @phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.ScopeNotCamelCaps
 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
 * @phpcs:disable SlevomatCodingStandard.PHP.DisallowReference.DisallowedPassingByReference
 * @phpcs:disable Squiz.NamingConventions.ValidVariableName.NotCamelCaps
 */
final class BlogReadFailStreamWrapper
{

    /**
     * @return array<string, int>
     */
    public function url_stat(string $path, int $flags): array
    {
        return [
            'atime' => 0,
            'ctime' => 0,
            'dev' => 0,
            'gid' => 0,
            'ino' => 0,
            'mode' => 0100444,
            'mtime' => 0,
            'size' => 0,
            'uid' => 0,
        ];
    }

    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path): bool
    {
        return false;
    }

}
