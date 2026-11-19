<?php

declare(strict_types = 1);

namespace App\Actions\Company;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Pekral\Arch\Action\ArchAction;

final readonly class GetCompanyFaviconPathAction implements ArchAction
{

    private const string SOURCE_URL = 'https://www.google.com/s2/favicons?domain=%s&sz=64';

    private const string STORAGE_DIRECTORY = 'company-icons';

    private const int MAX_AGE_SECONDS = 3_600 * 24 * 30;

    private const string FAILURE_CACHE_KEY = 'company_favicon_failed_%s';

    private const int FAILURE_TTL_SECONDS = 3_600;

    public function __construct(private GetCompanyWebsitesAction $getCompanyWebsites)
    {
    }

    public function execute(string $host): ?string
    {
        if (!$this->isKnownCompanyHost($host)) {
            return null;
        }

        $disk = Storage::disk('local');
        $path = sprintf('%s/%s.png', self::STORAGE_DIRECTORY, $host);

        if ($disk->exists($path) && time() - $disk->lastModified($path) < self::MAX_AGE_SECONDS) {
            return $disk->path($path);
        }

        $failureKey = sprintf(self::FAILURE_CACHE_KEY, $host);

        if (Cache::has($failureKey)) {
            return null;
        }

        try {
            $response = Http::timeout(5)->get(sprintf(self::SOURCE_URL, $host));
        } catch (ConnectionException) {
            $response = null;
        }

        if ($response === null || !$response->successful() || !str_starts_with($response->header('Content-Type'), 'image/')) {
            Cache::put($failureKey, value: true, ttl: self::FAILURE_TTL_SECONDS);

            return null;
        }

        $disk->put($path, $response->body());

        return $disk->path($path);
    }

    private function isKnownCompanyHost(string $host): bool
    {
        return array_any(
            $this->getCompanyWebsites->execute(),
            static fn (string $website): bool => parse_url($website, PHP_URL_HOST) === $host,
        );
    }

}
