@php
    use App\Models\Category;
    use App\Models\Project;
    use App\Models\Question;
    use App\Models\Response;
    use Illuminate\Database\Eloquent\Collection;
    /** @var Collection<Category> $categories */
    /** @var Question $question */
    /** @var Project $project */
    /** @var Response|null $response */
    /** @var int|null $nextQuestionId */
@endphp

@extends("layouts.project")

@section("project")

    <div class="flex h-full gap-4">
        <div class="w-1/3 shrink-0 h-full">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Questions</h6>
                <ul>
                    @foreach($categories as $category)
                        <li class="mb-3">
                            <div class="text-gray-400 font-black">{{ $category->title }}</div>
                            <ul>
                                @foreach($category->questions as $catQuestion)
                                    <li>
                                        <a
                                            href="{{ route("projects.questions.show", [$project, $catQuestion]) }}"
                                            @class([
                                            "flex items-center gap-2",
                                            "font-bold text-primary" => $catQuestion->id == $question->id,
                                            ])

                                        >
                                            @php($catQuestResp = $catQuestion->responses->first())
                                            @isset($catQuestResp)
                                                @switch($catQuestResp->answer)
                                                    @case(1)
                                                        @svg('fontisto-wink', 'w-5 shrink-0 text-green-500')
                                                        @break
                                                    @case(2)
                                                        @svg('fontisto-mad', 'w-5 shrink-0 text-red-500')
                                                        @break
                                                    @case(3)
                                                        @svg('fontisto-neutral', 'w-5 shrink-0 text-yellow-500')
                                                        @break
                                                @endswitch

                                            @else
                                                @svg('ri-checkbox-blank-circle-line', 'w-5 shrink-0')
                                            @endempty
                                            <div>
                                                {{ $catQuestion->question }}
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="w-full">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4 text-2xl">{{ $question->question }}</h6>

                <form method="POST" action="{{ route("projects.questions.answer", [$project, $question]) }}">
                    @csrf

                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="answer"
                            id="answerYes"
                            value="1"
                            onchange="this.form.submit()"
                            {{ $response?->answer == 1 ? "checked" : "" }}
                        >
                        <label class="form-check-label" for="answerYes">Yes</label>
                    </div>

                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="answer"
                            id="answerNo"
                            value="2"
                            onchange="this.form.submit()"
                            {{ $response?->answer == 2 ? "checked" : "" }}
                        >
                        <label class="form-check-label" for="answerNo">No</label>
                    </div>

                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="answer"
                            id="answerUnrelated"
                            value="3"
                            onchange="this.form.submit()"
                            {{ $response?->answer == 3 ? "checked" : "" }}
                        >
                        <label class="form-check-label" for="answerUnrelated">Unrelated</label>
                    </div>
                </form>

                <div class="mt-4">

                    @isset($nextQuestionId)
                        <a href="{{ route("projects.questions.show", [$project, $nextQuestionId]) }}">
                            <button type="button" class="btn btn-primary m-2 font-bold flex gap-2 items-center">
                                <span>Следующий Вопрос</span>
                                @svg('bx-right-arrow', 'w-4')
                            </button>
                        </a>
                    @endisset
                </div>
            </div>
        </div>
    </div>

@endsection
