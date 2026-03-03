<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\BlogService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

final class BlogImageController extends Controller
{

    public function __construct(private readonly BlogService $blogService) {}

    public function show(string $slug): BinaryFileResponse|Response
    {
        $path = $this->blogService->getImagePath($slug);

        if ($path === null) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

}
