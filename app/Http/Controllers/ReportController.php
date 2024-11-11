<?php

namespace App\Http\Controllers;

use App\Enums\AnswerType;
use App\Http\Requests\ReportRequest;
use App\Models\Project;
use App\Models\Report;
use App\Models\Response;
use Gate;
use Http;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $data = $project->responses->keyBy('question_id')->map(fn (Response $response) => [
            $response->answer,
            $response->reason,
        ]);

        $report = $project->reports()->create([
            'data' => $data,
            'email' => $request->get('email'),
        ]);

        return to_route('reports.show', $report);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Report $report): View
    {
        Gate::authorize('show', $report);
        $project = $report->project;
        $cat = Http::get('https://api.thecatapi.com/v1/images/search')->json('0.url');

        return view('reports.show', compact([
            'report', 'project', 'cat',
        ]));
    }

    /**
     * @throws ConnectionException
     */
    public function download(Report $report): StreamedResponse
    {
        $name = 'report_'.$report->created_at->timestamp.'.xlsx';
        $path = "reports/$name";
        $storage = Storage::disk('local');
        if (! $storage->exists($path)) {

            $listings = collect($report->statsFor(null)['listings']);

            $questions = $listings->pluck('question')->all();
            $answers = $listings->pluck('answer')->map(fn ($answer) => AnswerType::from($answer)->name)->all();
            $security_results = $listings->pluck('reason')->all();

            $data = compact('questions', 'answers', 'security_results');
            $host = config('services.maxim_excel.host');
            $port = config('services.maxim_excel.port');

            $res = Http::withBody(json_encode($data))
                ->post("http://$host:$port/export_to_excel");

            $storage->put($path, $res->body());
        }

        return $storage->download($path);
    }
}
