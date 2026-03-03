<?php

declare(strict_types = 1);

use App\Actions\Blog\GetBlogSlugsAction;
use App\Repositories\BlogContentRepository;

test('returns array of slugs from content directory', function (): void {
    $action = app(GetBlogSlugsAction::class);
    $slugs = $action->execute();

    expect($slugs)->toBeArray();
    expect($slugs)->toContain('vibe-coding-with-ai-good-servant-bad-master');
});

test('returns empty array when content path does not exist', function (): void {
    $repository = new BlogContentRepository(__DIR__ . '/../../../non-existent-blog-path-' . uniqid());
    $action = new GetBlogSlugsAction($repository);

    expect($action->execute())->toBe([]);
});

test('returns only directories that contain article.md', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    mkdir($base, 0755, true);
    file_put_contents($base . '/.gitkeep', '');
    $slug = 'valid-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: D\n---\n# Valid");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogSlugsAction($repository);
        expect($action->execute())->toBe([$slug]);
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        unlink($base . '/.gitkeep');
        rmdir($base);
    }
});
