<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Data\ArticleData;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Illuminate\Support\Collection;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\MarkdownConverter;
use Throwable;

use function is_string;

final readonly class BlogContentRepository
{

    private const string ARTICLE_FILE = 'article.md';

    private const string IMAGE_FILE = 'photo.jpg';

    public function __construct(private string $contentPath) {}

    /**
     * @return \Illuminate\Support\Collection<int, \App\Data\ArticleData>
     */
    public function getAll(): Collection
    {
        $slugs = $this->getSlugs();

        return collect($slugs)
            ->map(fn (string $slug): ?ArticleData => $this->getBySlug($slug))
            ->filter()
            ->sortByDesc(fn (ArticleData $a): CarbonInterface => $a->date)
            ->values();
    }

    public function getBySlug(string $slug): ?ArticleData
    {
        if (!$this->isValidSlug($slug)) {
            return null;
        }

        $articlePath = $this->contentPath . '/' . $slug . '/' . self::ARTICLE_FILE;

        if (!is_readable($articlePath) || is_dir($articlePath)) {
            return null;
        }

        $raw = file_get_contents($articlePath);

        // @codeCoverageIgnoreStart - file_get_contents false and DateTimeInterface branch not reachable from tests
        if ($raw === false) {
            return null;
        }

        /** @codeCoverageIgnoreEnd */
        $converter = $this->createConverter();
        $result = $converter->convert($raw);

        /** @var array<string, mixed> $frontMatter */
        $frontMatter = $result instanceof RenderedContentWithFrontMatter
            ? $result->getFrontMatter()
            : [];
        $htmlContent = $result->getContent();

        $markdownContent = $this->extractMarkdownBody($raw);
        $title = $this->extractTitleFromMarkdown($markdownContent) ?? $slug;
        $date = $this->parseDate($frontMatter['date'] ?? null) ?? Carbon::now();
        $descriptionRaw = $frontMatter['description'] ?? '';
        $description = is_string($descriptionRaw) ? $descriptionRaw : '';
        $imagePath = $this->contentPath . '/' . $slug . '/' . self::IMAGE_FILE;
        $hasImage = is_readable($imagePath);

        return new ArticleData(slug: $slug, title: $title, date: $date, description: $description, htmlContent: $htmlContent, hasImage: $hasImage);
    }

    /**
     * @return array<int, string>
     */
    public function getSlugs(): array
    {
        $dirs = $this->scanContentDirectories();

        if ($dirs === []) {
            return [];
        }

        $slugs = [];

        foreach ($dirs as $entry) {
            if ($this->isArticleDirectory($entry)) {
                $slugs[] = $entry;
            }
        }

        return $slugs;
    }

    public function getImagePath(string $slug): ?string
    {
        if (!$this->isValidSlug($slug)) {
            return null;
        }

        $path = $this->contentPath . '/' . $slug . '/' . self::IMAGE_FILE;

        return is_readable($path) ? $path : null;
    }

    /**
     * @return array<int, string>
     */
    private function scanContentDirectories(): array
    {
        if (!is_dir($this->contentPath)) {
            return [];
        }

        $dirs = scandir($this->contentPath);

        return $dirs !== false ? $dirs : [];
    }

    private function isArticleDirectory(string $entry): bool
    {
        if ($entry === '.' || $entry === '..') {
            return false;
        }

        $path = $this->contentPath . '/' . $entry;

        if (!is_dir($path)) {
            return false;
        }

        $articlePath = $path . '/' . self::ARTICLE_FILE;

        return is_readable($articlePath);
    }

    private function createConverter(): MarkdownConverter
    {
        $environment = new Environment([]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());

        return new MarkdownConverter($environment);
    }

    private function extractMarkdownBody(string $raw): string
    {
        if (preg_match('/^---\R.*?\R---\R/s', $raw, $m) === 1) {
            return (string) preg_replace('/^---\R.*?\R---\R/s', '', $raw);
        }

        return $raw;
    }

    private function extractTitleFromMarkdown(string $markdown): ?string
    {
        if (preg_match('/^#\s+(.+)$/m', trim($markdown), $m) === 1) {
            return trim($m[1]);
        }

        return null;
    }

    /**
     * @param mixed $value
     */
    private function parseDate($value): ?Carbon
    {
        if ($value === null) {
            return null;
        }

        // @codeCoverageIgnoreStart - front matter never returns DateTimeInterface from YAML
        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value);
        }

        // @codeCoverageIgnoreEnd

        if (is_numeric($value)) {
            return Carbon::createFromTimestamp((int) $value);
        }

        if (!is_scalar($value)) {
            return null;
        }

        try {
            return Carbon::parse((string) $value);
        } catch (Throwable) {
            return null;
        }
    }

    private function isValidSlug(string $slug): bool
    {
        return !in_array($slug, ['', '.', '..'], true) && !str_contains($slug, '/');
    }

}
