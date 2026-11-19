<?php

declare(strict_types = 1);

namespace App\Actions\GitHub;

use DOMDocument;
use DOMElement;
use DOMNameSpaceNode;
use DOMNode;
use DOMXPath;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Pekral\Arch\Action\ArchAction;

final readonly class GetGitHubRepositoryReadmeAction implements ArchAction
{

    private const string CACHE_KEY = 'github_readme_%s_v1';

    private const int CACHE_TTL_SECONDS = 3_600 * 4;

    private const string FAILURE_CACHE_KEY = 'github_readme_%s_failed';

    private const int FAILURE_TTL_SECONDS = 600;

    private const string README_URL = 'https://raw.githubusercontent.com/pekral/%s/HEAD/README.md';

    private const string RAW_BASE_URL = 'https://raw.githubusercontent.com/pekral/%s/HEAD/';

    private const string BLOB_BASE_URL = 'https://github.com/pekral/%s/blob/HEAD/';

    public function execute(string $repositoryName): ?string
    {
        $cacheKey = sprintf(self::CACHE_KEY, $repositoryName);
        $failureKey = sprintf(self::FAILURE_CACHE_KEY, $repositoryName);
        $html = Cache::get($cacheKey);

        if (!is_string($html)) {
            $html = Cache::has($failureKey) ? null : $this->fetchReadme($repositoryName, $cacheKey, $failureKey);
        }

        return is_string($html) && filled($html) ? $html : null;
    }

    private function fetchReadme(string $repositoryName, string $cacheKey, string $failureKey): ?string
    {
        try {
            $response = Http::timeout(10)->get(sprintf(self::README_URL, $repositoryName));
        } catch (ConnectionException) {
            $response = null;
        }

        if ($response === null || !($response->successful() || $response->notFound())) {
            Cache::put($failureKey, value: true, ttl: self::FAILURE_TTL_SECONDS);

            return null;
        }

        $html = $response->successful() && filled($response->body()) ? $this->renderReadme($response->body(), $repositoryName) : '';
        Cache::put($cacheKey, $html, self::CACHE_TTL_SECONDS);

        return $html;
    }

    private function renderReadme(string $markdown, string $repositoryName): string
    {
        $environment = new Environment([
            'allow_unsafe_links' => false,
            'html_input' => 'strip',
            'max_nesting_level' => 50,
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $html = new MarkdownConverter($environment)->convert($markdown)->getContent();

        return $this->resolveRelativeUrls($html, $repositoryName);
    }

    private function resolveRelativeUrls(string $html, string $repositoryName): string
    {
        $document = new DOMDocument();
        $document->loadHTML(
            '<?xml encoding="utf-8" ?><div id="readme-root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR,
        );
        $xpath = new DOMXPath($document);

        foreach ($xpath->query('//img[@src]') ?: [] as $image) {
            $this->absolutize($image, 'src', sprintf(self::RAW_BASE_URL, $repositoryName));
        }

        foreach ($xpath->query('//a[@href]') ?: [] as $anchor) {
            $this->absolutize($anchor, 'href', sprintf(self::BLOB_BASE_URL, $repositoryName));
        }

        $root = $document->getElementById('readme-root');
        assert($root instanceof DOMElement);
        $inner = '';

        foreach ($root->childNodes as $child) {
            $inner .= $document->saveHTML($child);
        }

        return $inner;
    }

    private function relativePath(string $value): string
    {
        return preg_replace('~^(?:\./)+|^/+~', '', $value) ?? $value;
    }

    private function absolutize(DOMNameSpaceNode|DOMNode $element, string $attribute, string $base): void
    {
        assert($element instanceof DOMElement);
        $value = trim($element->getAttribute($attribute));

        if ($value === '' || str_starts_with($value, '#') || preg_match('~^(?:[a-z][a-z0-9+.-]*:|//)~i', $value) === 1) {
            return;
        }

        $element->setAttribute($attribute, $base . $this->relativePath($value));
    }

}
