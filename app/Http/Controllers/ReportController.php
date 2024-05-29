<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Project;
use App\Models\Question;
use App\Models\Report;
use App\Models\Response;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Project $project): View
    {
        Gate::authorize('index', [Report::class, $project]);
        $project->load('reports');

        return view('reports.index', compact(
            'project'
        ));
    }

    /**
     * @throws AuthorizationException
     */
    public function create(Project $project): View|RedirectResponse
    {
        Gate::authorize('create', [Report::class, $project]);

        return view('reports.create', compact([
            'project',
        ]));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Project $project, ReportRequest $request): RedirectResponse
    {
        Gate::authorize('create', [Report::class, $project]);

        $project->load('responses');

        $data = $project->responses->pluck('answer', 'question_id');
        $report = $project->reports()->create([
            'data' => $data,
            'email' => $request->get("email"),
        ]);

        return to_route("reports.show", $report);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Report $report): View
    {
        Gate::authorize('show', $report);

        $project = $report->project;
        $data = collect($report->data);
        $questions = Question::findMany($data->keys());
        $categories = $questions->load('category')->pluck('category')->unique();

        return view("reports.show", compact([
            'report', 'project', 'questions', 'categories',
        ]));
    }
}
