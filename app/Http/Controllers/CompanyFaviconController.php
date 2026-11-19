<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Actions\Company\GetCompanyFaviconPathAction;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class CompanyFaviconController extends Controller
{

    private const int MAX_AGE_SECONDS = 3_600 * 24 * 30;

    private const int PLACEHOLDER_MAX_AGE_SECONDS = 3_600;

    private const string TRANSPARENT_PIXEL_PNG = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    public function show(GetCompanyFaviconPathAction $getCompanyFaviconPath, string $host): BinaryFileResponse|Response
    {
        $path = $getCompanyFaviconPath->execute($host);

        if ($path === null) {
            return response(base64_decode(self::TRANSPARENT_PIXEL_PNG, strict: true), 200, [
                'Cache-Control' => sprintf('public, max-age=%d', self::PLACEHOLDER_MAX_AGE_SECONDS),
                'Content-Type' => 'image/png',
            ]);
        }

        return response()->file($path, [
            'Cache-Control' => sprintf('public, max-age=%d', self::MAX_AGE_SECONDS),
            'Content-Type' => 'image/png',
        ]);
    }

}
