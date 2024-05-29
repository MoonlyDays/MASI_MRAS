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
            'project'
        ]));
    }

    public function store(Project $project, ReportRequest $request): RedirectResponse
    {
        $project->load([
            'responses',
            'responses.question',
            'responses.question.category'
        ]);

        dd($project);

        $related_responses = 0;
        $correct_responses = 0;

        foreach ($project->responses as $response) {
            if ($response->answer == Response::UNRELATED) {
                continue;
            }

            $related_responses++;

        }

        dd(compact(
            'related_responses',
            'correct_responses'
        ));
    }
}
