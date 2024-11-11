<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class DocsController extends Controller
{
    /**
     * @throws FileNotFoundException
     */
    public function docs(string $page = 'main')
    {
        return measure('yeblan?', function () use ($page) {

            $docs = File::get(resource_path('docs/'.$page.'.md'));

            return view('docs', [
                'content' => $docs,
            ]);
        });
    }
}
