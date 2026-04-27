<?php

declare(strict_types = 1);

use App\Actions\Blog\GetAllBlogArticlesAction;
use App\Data\ArticleData;

test('returns collection of articles sorted by date descending', function (): void {
    $action = app(GetAllBlogArticlesAction::class);
    $articles = $action->execute();

    expect($articles)->not->toBeEmpty();
    $slugs = $articles->map(fn (ArticleData $a): string => $a->slug)->all();
    expect($slugs)->toContain('vibe-coding-with-ai-good-servant-bad-master');
    expect($slugs)->toContain('cursor-editor-ai-productivity-developer');

    $dates = $articles->map(fn (ArticleData $a): \Carbon\CarbonInterface => $a->date)->all();
    $sortedDates = collect($dates)->sortDesc()->values()->all();
    expect($dates)->toBe($sortedDates);
});
