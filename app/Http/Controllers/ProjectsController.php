<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerQuestionRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Question;
use Auth;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    public function index(): RedirectResponse
    {
        $user = Auth::user();
        $project = $user->projects()->first();
        if (empty($project)) {
            return to_route('projects.create');
        }

        return to_route('projects.show', $project);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        Gate::authorize('create', Project::class);

        return view('projects.create');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        Gate::authorize('create', Project::class);

        $user = Auth::user();
        $data = $request->validated();
        $project = $user->projects()->create($data);

        return to_route('projects.show', $project);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Project $project): RedirectResponse
    {
        Gate::authorize('show', $project);

        return to_route('projects.questions.show', [$project, 1]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Project $project): View
    {
        Gate::authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Project $project, ProjectRequest $request): RedirectResponse
    {
        Gate::authorize('update', $project);

        $data = $request->validated();
        $project->update($data);

        return to_route('projects.show', $project);
    }

    /**
     * @throws AuthorizationException
     */
    public function question(Project $project, Question $question): View
    {
        Gate::authorize('update', $project);
        $question->load('category');

        $categories = Category::with([
            'questions' => [
                'responses' => fn ($query) => $query->where('project_id', $project->id),
            ],
        ])->get();
        $nextQuestionId = Question::where('id', '>', $question->id)->min('id');
        $response = $project->responses()
            ->where('question_id', $question->id)
            ->first();

        return view('projects.show', compact(
            'project',
            'categories',
            'question',
            'nextQuestionId',
            'response'
        ));
    }

    /**
     * @throws AuthorizationException
     */
    public function answer(Project $project, Question $question, AnswerQuestionRequest $request): RedirectResponse
    {
        Gate::authorize('update', $project);

        $project->setAnswerFor(
            $question,
            $request->get('answer'),
            $request->get('reason')
        );

        $nextQuestion = $question->next();
        if (isset($nextQuestion)) {
            return to_route('projects.questions.show', [$project, $nextQuestion]);
        }

        return back();
    }
}
