<?php

declare(strict_types = 1);

use App\Actions\Blog\GetPaginatedBlogArticlesAction;
use App\Data\ArticleData;
use Illuminate\Pagination\LengthAwarePaginator;

test('returns paginator with first page of articles', function (): void {
    $action = app(GetPaginatedBlogArticlesAction::class);
    $paginator = $action->execute();

    expect($paginator)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($paginator->currentPage())->toBe(1);
    expect($paginator->perPage())->toBe(10);
    expect($paginator->total())->toBeGreaterThan(0);
    expect($paginator->items())->toBeArray();
    expect(count($paginator->items()))->toBeLessThanOrEqual(10);

    $items = $paginator->items();
    $first = $items[0] ?? null;
    expect($first)->toBeInstanceOf(ArticleData::class);
    expect($paginator->total())->toBeGreaterThanOrEqual(2);
    $slugs = collect($items)->map(fn (ArticleData $a): string => $a->slug)->all();
    expect($slugs)->toContain('vibe-coding-with-ai-good-servant-bad-master');
    expect($slugs)->toContain('cursor-editor-ai-productivity-developer');
});

test('respects page parameter', function (): void {
    $action = app(GetPaginatedBlogArticlesAction::class);
    $paginator = $action->execute(2);

    expect($paginator->currentPage())->toBe(2);
});

test('invalid page defaults to 1', function (): void {
    $action = app(GetPaginatedBlogArticlesAction::class);
    $paginator = $action->execute(0);

    expect($paginator->currentPage())->toBe(1);
});
