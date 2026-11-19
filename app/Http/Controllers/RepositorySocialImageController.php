<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Actions\GitHub\GetRepositorySocialImagePathAction;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class RepositorySocialImageController extends Controller
{

    private const string FALLBACK_URL = 'https://opengraph.githubassets.com/pekral/pekral/%s';

    private const int MAX_AGE_SECONDS = 14_400;

    public function show(GetRepositorySocialImagePathAction $getRepositorySocialImagePath, string $name): BinaryFileResponse|RedirectResponse
    {
        $path = $getRepositorySocialImagePath->execute($name);

        if ($path === null) {
            return redirect()->away(sprintf(self::FALLBACK_URL, $name));
        }

        return response()->file($path, [
            'Cache-Control' => sprintf('public, max-age=%d', self::MAX_AGE_SECONDS),
            'Content-Type' => 'image/webp',
        ]);
    }

}
