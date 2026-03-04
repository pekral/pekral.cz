<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Data\ArticleData;
use App\Data\ArticleHeadingData;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Collection;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkProcessor;
use League\CommonMark\MarkdownConverter;
use Throwable;

use function assert;
use function is_string;

final readonly class BlogContentRepository
{

    private const string ARTICLE_FILE = 'article.md';

    private const string IMAGE_FILE = 'photo.jpg';

    private const string FRONT_MATTER_REGEX = '/^---\R.*?\R---\R/s';

    private const int DEFAULT_READING_WPM = 200;

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

        $articlePath = $this->articleFilePath($slug);

        if (!is_readable($articlePath) || is_dir($articlePath)) {
            return null;
        }

        $raw = file_get_contents($articlePath);

        if ($raw === false) {
            return null;
        }

        $converter = $this->createConverter();
        $result = $converter->convert($raw);

        return $this->buildArticleData($slug, $raw, $result);
    }

    /**
     * @return array<int, string>
     */
    public function getSlugs(): array
    {
        return collect($this->scanContentDirectories())
            ->filter(fn (string $entry): bool => $this->isArticleDirectory($entry))
            ->values()
            ->all();
    }

    /**
     * @return string|null absolute path to photo.jpg or null if missing/invalid slug
     */
    public function getImagePath(string $slug): ?string
    {
        if (!$this->isValidSlug($slug)) {
            return null;
        }

        $path = $this->imageFilePath($slug);

        return is_readable($path) ? $path : null;
    }

    private function articleFilePath(string $slug): string
    {
        return $this->contentPath . '/' . $slug . '/' . self::ARTICLE_FILE;
    }

    private function imageFilePath(string $slug): string
    {
        return $this->contentPath . '/' . $slug . '/' . self::IMAGE_FILE;
    }

    /**
     * @param \League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter|\League\CommonMark\Output\RenderedContentInterface $result
     */
    private function buildArticleData(string $slug, string $raw, mixed $result): ArticleData
    {
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
        $hasImage = is_readable($this->imageFilePath($slug));
        $readingTimeMinutes = $this->computeReadingTimeMinutes($htmlContent);
        $headings = $this->extractHeadingsFromHtml($htmlContent);

        return new ArticleData(
            slug: $slug,
            title: $title,
            date: $date,
            description: $description,
            htmlContent: $htmlContent,
            hasImage: $hasImage,
            readingTimeMinutes: $readingTimeMinutes,
            headings: $headings,
        );
    }

    /**
     * @return array<int, \App\Data\ArticleHeadingData>
     */
    private function extractHeadingsFromHtml(string $htmlContent): array
    {
        $dom = new DOMDocument();
        $useErrors = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><div>' . $htmlContent . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors($useErrors);

        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//h2 | //h3');

        if ($nodes === false || $nodes->length === 0) {
            return [];
        }

        $headings = [];

        foreach ($nodes as $node) {
            assert($node instanceof DOMElement);

            $id = $node->getAttribute('id');

            if ($id === '') {
                continue;
            }

            $text = trim($node->textContent ?? '');

            if ($text !== '') {
                $headings[] = new ArticleHeadingData(id: $id, text: $text);
            }
        }

        return $headings;
    }

    private function computeReadingTimeMinutes(string $htmlContent): int
    {
        $text = strip_tags($htmlContent);
        $wordCount = str_word_count($text, 0, '0123456789áčďéěíňóřšťúůýžÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ');

        if ($wordCount <= 0) {
            return 1;
        }

        $wpmConfig = config('blog.reading_words_per_minute', self::DEFAULT_READING_WPM);
        $wpm = is_numeric($wpmConfig) ? max(1, (int) $wpmConfig) : self::DEFAULT_READING_WPM;
        $minutes = (int) ceil($wordCount / $wpm);

        return max(1, $minutes);
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

        $dirPath = $this->contentPath . '/' . $entry;

        if (!is_dir($dirPath)) {
            return false;
        }

        return is_readable($this->articleFilePath($entry));
    }

    private function createConverter(): MarkdownConverter
    {
        $config = [
            'heading_permalink' => [
                'apply_id_to_heading' => true,
                'fragment_prefix' => '',
                'id_prefix' => '',
                'insert' => HeadingPermalinkProcessor::INSERT_NONE,
                'max_heading_level' => 3,
                'min_heading_level' => 2,
            ],
        ];
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());
        $environment->addExtension(new HeadingPermalinkExtension());

        return new MarkdownConverter($environment);
    }

    private function extractMarkdownBody(string $raw): string
    {
        if (preg_match(self::FRONT_MATTER_REGEX, $raw) === 1) {
            return (string) preg_replace(self::FRONT_MATTER_REGEX, '', $raw);
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

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value);
        }

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
