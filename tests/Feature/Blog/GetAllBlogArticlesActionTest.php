<?php

declare(strict_types = 1);

use App\Actions\Blog\GetAllBlogArticlesAction;
use App\Data\ArticleData;

test('returns collection of articles sorted by date descending', function (): void {
    $action = app(GetAllBlogArticlesAction::class);
    $articles = $action->execute();

    expect($articles)->not->toBeEmpty();
    $first = $articles->first();
    expect($first)->toBeInstanceOf(ArticleData::class);
    assert($first instanceof ArticleData);
    expect($first->slug)->toBe('vibe-coding-with-ai-good-servant-bad-master');
});
