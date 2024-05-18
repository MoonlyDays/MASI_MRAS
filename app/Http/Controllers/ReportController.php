<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Project $project): View
    {
        return view('reports.index', compact(
            'project'
        ));
    }
}
