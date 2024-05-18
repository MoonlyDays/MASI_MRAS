<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerQuestionRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Question;
use App\Models\Response;
use Auth;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    function index(): View
    {
        Gate::authorize("index", Project::class);

        return view("projects.index");
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        Gate::authorize("create", Project::class);

        return view("projects.create");
    }

    /**
     * @throws AuthorizationException
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        Gate::authorize("create", Project::class);

        $user = Auth::user();
        $data = $request->validated();
        $project = $user->projects()->create($data);

        return to_route("projects.show", $project);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Project $project): RedirectResponse
    {
        Gate::authorize("show", $project);

        return to_route("projects.questions.show", [$project, 1]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Project $project): View
    {
        Gate::authorize("update", $project);

        return view("projects.edit", compact("project"));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Project $project, ProjectRequest $request): RedirectResponse
    {
        Gate::authorize("update", $project);

        $data = $request->validated();
        $project->update($data);

        return to_route("projects.show", $project);
    }

    public function question(Project $project, Question $question): View
    {
        $categories = Category::with([
            "questions" => [
                "responses" => fn($query) => $query->where('project_id', $project->id),
            ],
        ])->get();
        $nextQuestionId = Question::where("id", '>', $question->id)->min("id");
        $response = $project->responses()->question($question)->first();

        return view("projects.show", compact(
            "project",
            "categories",
            "question",
            "nextQuestionId",
            "response"
        ));
    }

    public function answer(Project $project, Question $question, AnswerQuestionRequest $request): RedirectResponse
    {
        /** @var Response $response */
        $response = $project->responses()->question($question)->firstOrNew();
        $response->question_id = $question->id;
        $response->fill($request->validated());
        $response->save();

        $nextQuestion = $question->next();
        if (isset($nextQuestion)) {
            return to_route("projects.questions.show", [$project, $nextQuestion]);
        }

        return back();
    }
}
