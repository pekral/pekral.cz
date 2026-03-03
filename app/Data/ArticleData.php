<?php

declare(strict_types = 1);

namespace App\Data;

use Carbon\CarbonInterface;

final readonly class ArticleData
{

    public function __construct(
        public string $slug,
        public string $title,
        public CarbonInterface $date,
        public string $description,
        public string $htmlContent,
        public bool $hasImage,
        public int $readingTimeMinutes,
    ) {}

}
