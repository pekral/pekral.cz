<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\BlogService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

final class BlogImageController extends Controller
{
    public function show(BlogService $blogService, string $slug): BinaryFileResponse|Response
    {
        $path = $blogService->getImagePath($slug);

        if ($path === null) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
}
