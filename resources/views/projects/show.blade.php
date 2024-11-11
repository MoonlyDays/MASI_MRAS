@php
    use App\Enums\AnswerType;use App\Models\Category;
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
                <div>
                    @foreach($categories as $category)
                        <div class="mb-3">
                            <div class="text-gray-400 font-black">{{ $category->title }}</div>
                            <div>
                                @foreach($category->questions as $catQuestion)
                                    <div>
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
                                                    @case(AnswerType::YES->value)
                                                        @svg('fontisto-wink', 'w-5 shrink-0 text-green-500')
                                                        @break
                                                    @case(AnswerType::NO->value)
                                                        @svg('fontisto-mad', 'w-5 shrink-0 text-red-500')
                                                        @break
                                                    @case(AnswerType::UNRELATED->value)
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="bg-secondary rounded h-100 p-4">
                <div>{{ $question->category->title }}</div>
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
                                onchange="document.querySelector('#answerReason').disabled = false;"
                                {{ $response?->answer == 3 ? "checked" : "" }}
                        >
                        <label class="form-check-label" for="answerUnrelated">Unrelated</label>
                    </div>

                    <div class="form-check">
                        <select
                                {{ $response?->answer == AnswerType::UNRELATED->value ? "" : "disabled" }}
                                class="form-select w-full disabled:opacity-20"
                                name="reason"
                                id="answerReason"
                                onchange="this.form.submit()"
                        >
                            <option disabled>
                                -- Выберите причину тряски --
                            </option>
                            <option>
                                Устаревший стандарт: Вопрос относится к стандарту, который больше не используется в
                                нашей системе управления.
                            </option>
                            <option>
                                Не используем такую политику: Политика, упомянутая в вопросе, не применяется в
                                рамках нашей текущей системы управления.
                            </option>
                            <option>
                                Отказались от политики: Политика была ранее использована, но была отменена или
                                заменена другой.
                            </option>
                            <option>
                                Не релевантно к текущей инфраструктуре: Вопрос не имеет отношения к текущей
                                ИКТ-инфраструктуре организации.
                            </option>
                            <option>
                                Вопрос вне сферы нашей деятельности: Вопрос касается области, которая не входит в нашу
                                сферу деятельности или ответственности.
                            </option>
                            <option>
                                Требования не применимы: Указанные требования не применимы к нашей организации из-за
                                особенностей нашей деятельности.
                            </option>
                            <option>
                                Политика не соответствует законодательству: Политика, указанная в вопросе, не
                                соответствует местным или международным законодательным требованиям.
                            </option>
                            <option>
                                Используем другой подход: Вопрос касается метода или подхода, который не
                                используется в нашей организации.
                            </option>
                            <option>
                                Неактуально для текущих процессов: Вопрос неактуален для наших текущих процессов и
                                процедур.
                            </option>
                            <option>
                                Неприменимо к нашему типу данных: Вопрос касается типов данных, которые не
                                обрабатываются нашей системой.
                            </option>

                            <option>
                                Политика не поддерживается нашими системами: Наши системы не поддерживают указанную
                                политику или методологию.
                            </option>

                            <option>
                                Не предусмотрено стратегией безопасности: Вопрос не отражает наши стратегические
                                цели и планы в области информационной безопасности.
                            </option>

                            <option>
                                Не связано с нашей операционной деятельностью: Вопрос не связан с повседневной
                                операционной деятельностью нашей организации.
                            </option>

                            <option>
                                Недостаточно информации для применения: Вопрос не содержит достаточной информации
                                для его применения в нашей системе.
                            </option>

                            <option>
                                Конфликтует с другими политиками: Политика, указанная в вопросе, конфликтует с
                                другими нашими политиками и процедурами
                            </option>
                        </select>

                        <script>
                            (() => {
                                const select = document.querySelector('#answerReason');
                                const reason = "{{ $response?->reason }}";
                                select.selectedIndex = Array.from(select.options).findIndex(x => x.value === reason);
                                if (select.selectedIndex < 0) select.selectedIndex = 0;
                            })();
                        </script>
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
