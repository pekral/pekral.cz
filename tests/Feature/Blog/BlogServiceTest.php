<?php

declare(strict_types = 1);

use App\Actions\Blog\GetAllBlogArticlesAction;
use App\Actions\Blog\GetBlogArticleBySlugAction;
use App\Actions\Blog\GetBlogImagePathAction;
use App\Actions\Blog\GetBlogSlugsAction;
use App\Data\ArticleData;
use App\Repositories\BlogContentRepository;
use Carbon\Carbon;

test('getSlugs returns directory names that contain article.md', function (): void {
    $getBlogSlugs = app(GetBlogSlugsAction::class);

    $slugs = $getBlogSlugs->execute();

    expect($slugs)->toBeArray();
    expect($slugs)->toContain('vibe-coding-with-ai-good-servant-bad-master');
});

test('getBySlug returns article data for existing slug', function (): void {
    $getBlogArticleBySlug = app(GetBlogArticleBySlugAction::class);

    $article = $getBlogArticleBySlug->execute('vibe-coding-with-ai-good-servant-bad-master');

    expect($article)->toBeInstanceOf(ArticleData::class);
    assert($article instanceof ArticleData);
    expect($article->slug)->toBe('vibe-coding-with-ai-good-servant-bad-master');
    expect($article->title)->toContain('Vibe coding with AI');
    expect($article->description)->not->toBeEmpty();
    expect($article->htmlContent)->toContain('<h1>');
    expect($article->date)->not->toBeNull();
    expect($article->hasImage)->toBeTrue();
});

test('getBySlug returns null for non-existent slug', function (): void {
    $getBlogArticleBySlug = app(GetBlogArticleBySlugAction::class);

    $article = $getBlogArticleBySlug->execute('non-existent-slug-xyz');

    expect($article)->toBeNull();
});

test('getBySlug returns null for invalid slug with path traversal', function (): void {
    $getBlogArticleBySlug = app(GetBlogArticleBySlugAction::class);

    expect($getBlogArticleBySlug->execute('../etc/passwd'))->toBeNull();
    expect($getBlogArticleBySlug->execute('foo/bar'))->toBeNull();
});

test('getAll returns collection of articles sorted by date descending', function (): void {
    $getAllBlogArticles = app(GetAllBlogArticlesAction::class);

    $articles = $getAllBlogArticles->execute();

    expect($articles)->not->toBeEmpty();
    $first = $articles->first();
    expect($first)->toBeInstanceOf(ArticleData::class);
    assert($first instanceof ArticleData);
    expect($first->slug)->toBe('vibe-coding-with-ai-good-servant-bad-master');
});

test('getImagePath returns path for slug with photo.jpg', function (): void {
    $getBlogImagePath = app(GetBlogImagePathAction::class);

    $path = $getBlogImagePath->execute('vibe-coding-with-ai-good-servant-bad-master');

    expect($path)->not->toBeNull();
    assert($path !== null);
    expect($path)->toContain('vibe-coding-with-ai-good-servant-bad-master');
    expect($path)->toEndWith('photo.jpg');
    expect(file_exists($path))->toBeTrue();
});

test('getImagePath returns null for non-existent slug', function (): void {
    $getBlogImagePath = app(GetBlogImagePathAction::class);

    $path = $getBlogImagePath->execute('non-existent');

    expect($path)->toBeNull();
});

test('getImagePath returns null for invalid slug', function (): void {
    $getBlogImagePath = app(GetBlogImagePathAction::class);

    expect($getBlogImagePath->execute(''))->toBeNull();
    expect($getBlogImagePath->execute('foo/bar'))->toBeNull();
});

test('getSlugs returns empty array when content path does not exist', function (): void {
    $repository = new BlogContentRepository(__DIR__ . '/../../../non-existent-blog-path-' . uniqid());
    $getBlogSlugs = new GetBlogSlugsAction($repository);

    expect($getBlogSlugs->execute())->toBe([]);
});

test('getImagePath returns null when article directory has no photo', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-image-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: Test\n---\n# No Image");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogImagePath = new GetBlogImagePathAction($repository);
        expect($getBlogImagePath->execute($slug))->toBeNull();
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('getSlugs ignores files and only returns directories with article.md', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    mkdir($base, 0755, true);
    file_put_contents($base . '/.gitkeep', '');
    $slug = 'valid-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: D\n---\n# Valid");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogSlugs = new GetBlogSlugsAction($repository);
        $slugs = $getBlogSlugs->execute();
        expect($slugs)->toBe([$slug]);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        unlink($base . '/.gitkeep');
        rmdir($base);
    }
});

test('getBySlug parses article without front matter', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-front-matter';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "Plain text\n\n# Title From Content");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogArticleBySlug = new GetBlogArticleBySlugAction($repository);
        $article = $getBlogArticleBySlug->execute($slug);
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

test('getBySlug uses slug as title when article has no h1', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-h1-heading';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: D\n---\nJust paragraph.");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogArticleBySlug = new GetBlogArticleBySlugAction($repository);
        $article = $getBlogArticleBySlug->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->title)->toBe($slug);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('getBySlug parses numeric date from front matter', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'timestamp-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 1609459200\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogArticleBySlug = new GetBlogArticleBySlugAction($repository);
        $article = $getBlogArticleBySlug->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->date->format('Y-m-d'))->toBe('2021-01-01');
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('getBySlug uses default date for invalid date in front matter', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'invalid-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: not-a-date\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogArticleBySlug = new GetBlogArticleBySlugAction($repository);
        $article = $getBlogArticleBySlug->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->date)->toBeInstanceOf(Carbon::class);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('getBySlug uses default date when front matter date is non-scalar', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'array-date';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: []\ndescription: D\n---\n# Title");

    try {
        $repository = new BlogContentRepository($base);
        $getBlogArticleBySlug = new GetBlogArticleBySlugAction($repository);
        $article = $getBlogArticleBySlug->execute($slug);
        expect($article)->not->toBeNull();
        assert($article instanceof ArticleData);
        expect($article->date)->toBeInstanceOf(Carbon::class);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});

test('getBySlug returns null when article path is a directory', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'dir-as-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    mkdir($articleDir . '/article.md', 0755);

    try {
        $repository = new BlogContentRepository($base);
        $getBlogArticleBySlug = new GetBlogArticleBySlugAction($repository);
        expect($getBlogArticleBySlug->execute($slug))->toBeNull();
    } finally {
        rmdir($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});
