<?php

declare(strict_types = 1);

use App\Actions\Blog\GetBlogImagePathAction;
use App\Repositories\BlogContentRepository;

test('returns path for slug with photo', function (): void {
    $action = app(GetBlogImagePathAction::class);
    $path = $action->execute('vibe-coding-with-ai-good-servant-bad-master');

    expect($path)->not->toBeNull();
    assert($path !== null);
    expect($path)->toContain('vibe-coding-with-ai-good-servant-bad-master');
    expect($path)->toEndWith('photo.jpg');
    expect(file_exists($path))->toBeTrue();
});

test('returns null for non-existent slug', function (): void {
    $action = app(GetBlogImagePathAction::class);
    expect($action->execute('non-existent'))->toBeNull();
});

test('returns null for invalid slug', function (): void {
    $action = app(GetBlogImagePathAction::class);
    expect($action->execute(''))->toBeNull();
    expect($action->execute('foo/bar'))->toBeNull();
});

test('returns null when article directory has no photo', function (): void {
    $base = sys_get_temp_dir() . '/blog-test-' . uniqid();
    $slug = 'no-image-article';
    $articleDir = $base . '/' . $slug;
    mkdir($articleDir, 0755, true);
    file_put_contents($articleDir . '/article.md', "---\ndate: 2020-01-01\ndescription: Test\n---\n# No Image");

    try {
        $repository = new BlogContentRepository($base);
        $action = new GetBlogImagePathAction($repository);
        expect($action->execute($slug))->toBeNull();
    } finally {
        unlink($articleDir . '/article.md');
        rmdir($articleDir);
        rmdir($base);
    }
});
