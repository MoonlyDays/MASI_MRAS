<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocsController extends Controller
{
    /**
     * @throws FileNotFoundException
     */
    public function docs(): View
    {
        $docs = File::get(resource_path("docs/main.md"));

        return view("docs", [
            "content" => $docs,
        ]);
    }
}
