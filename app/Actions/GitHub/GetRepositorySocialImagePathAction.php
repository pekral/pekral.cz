<?php

declare(strict_types = 1);

namespace App\Actions\GitHub;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Pekral\Arch\Action\ArchAction;

final readonly class GetRepositorySocialImagePathAction implements ArchAction
{

    private const string SOURCE_URL = 'https://opengraph.githubassets.com/pekral/pekral/%s';

    private const string STORAGE_DIRECTORY = 'github-social';

    private const int WIDTH = 640;

    private const int HEIGHT = 320;

    private const int WEBP_QUALITY = 80;

    private const int MAX_AGE_SECONDS = 3_600 * 4;

    private const string FAILURE_CACHE_KEY = 'github_social_image_failed_%s';

    private const int FAILURE_TTL_SECONDS = 600;

    public function execute(string $repositoryName): ?string
    {
        $disk = Storage::disk('local');
        $path = sprintf('%s/%s.webp', self::STORAGE_DIRECTORY, $repositoryName);

        if ($disk->exists($path) && time() - $disk->lastModified($path) < self::MAX_AGE_SECONDS) {
            return $disk->path($path);
        }

        $failureKey = sprintf(self::FAILURE_CACHE_KEY, $repositoryName);

        if (Cache::has($failureKey)) {
            return null;
        }

        $webp = $this->downloadAndResize($repositoryName);

        if ($webp === null) {
            Cache::put($failureKey, value: true, ttl: self::FAILURE_TTL_SECONDS);

            return null;
        }

        $disk->put($path, $webp);

        return $disk->path($path);
    }

    private function downloadAndResize(string $repositoryName): ?string
    {
        $response = Http::timeout(10)->get(sprintf(self::SOURCE_URL, $repositoryName));

        if (!$response->successful()) {
            return null;
        }

        $source = @imagecreatefromstring($response->body());

        if ($source === false) {
            return null;
        }

        $target = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        imagecopyresampled($target, $source, 0, 0, 0, 0, self::WIDTH, self::HEIGHT, imagesx($source), imagesy($source));

        ob_start();
        imagewebp($target, quality: self::WEBP_QUALITY);
        $webp = ob_get_clean();

        return is_string($webp) && filled($webp) ? $webp : null;
    }

}
