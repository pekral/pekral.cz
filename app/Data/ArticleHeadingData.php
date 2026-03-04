<?php

declare(strict_types = 1);

namespace App\Data;

final readonly class ArticleHeadingData
{

    public function __construct(public string $id, public string $text) {}

}
