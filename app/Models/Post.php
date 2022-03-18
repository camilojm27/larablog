<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class Post
{
    public static function all(): array
    {
        $files = File::files(resource_path("posts/"));

        return array_map(fn($file) => $file->getContents(), $files);
    }
    public static function find($slug): View | ModelNotFoundException
    {
        if (!file_exists($path = resource_path("posts/$slug.html"))) {
            throw new ModelNotFoundException();
        }

        $post = cache()->remember("posts.{slug}", 1200, fn() => file_get_contents($path));

        return view('post', ['post' => $post]);
    }
}
