<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Actions\Blog\GetBlogImagePathAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

final class BlogImageController extends Controller
{

    public function show(GetBlogImagePathAction $getBlogImagePath, string $slug): BinaryFileResponse|Response
    {
        $path = $getBlogImagePath->execute($slug);

        if ($path === null) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

}
