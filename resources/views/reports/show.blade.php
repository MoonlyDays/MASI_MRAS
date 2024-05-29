@php
    use App\Models\Category;
    use App\Models\Question;
    use App\Models\Report;
    use App\Models\Response;
    use App\Models\Project;
    use Illuminate\Database\Eloquent\Collection;
    /** @var Report $report */
    /** @var Project $project */
    /** @var Collection<Question> $questions */
    /** @var Collection<Category> $categories */

    $data = collect($report->data);

    $answerDisplay = [
        '???',
        'Yes',
        'No',
        'Unrelated',
    ];

@endphp

@extends("layouts.project")

@section("project")

    <div class="grid grid-cols-1 gap-2">

        <div class="bg-secondary rounded py-3 px-4 mb-2">
            <h6 class="text-xl">Report generated from {{ $report->created_at->toDateTimeString() }}</h6>
        </div>

        @foreach($categories as $category)
            <div class="bg-secondary rounded py-3 px-4">
                <h6 class="mb-4">{{ $category->title }}</h6>

                @php
                    $categoryData = $data->only($category->questions->pluck('id'));
                    $totalCount = $categoryData->count();
                    $unrelatedCount = $categoryData->filter(function ($x) { return $x == Response::UNRELATED; })->count();
                    $relatedCount = $totalCount - $unrelatedCount;
                    $correctCount = $categoryData->filter(function ($x) { return $x == Response::YES; })->count();
                    $incorrectCount = $relatedCount - $correctCount;
                @endphp

                <table class="table">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category->questions as $question)
                        <tr>
                            <td> {{ $question->question }}</td>
                            <td>
                                @switch($categoryData[$question->id] ?? 0)
                                    @case(Response::UNRELATED)
                                        <div class="text-yellow-500">Unrelated</div>
                                        @break
                                    @case(Response::YES)
                                        <div class="text-green-500">Yes</div>
                                        @break
                                    @case(Response::NO)
                                        <div class="text-red-500">No</div>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <canvas id="canvas_category_{{ $category->id }}" class="max-h-64"></canvas>
                <script>
                    new Chart(document.querySelector("#canvas_category_{{ $category->id }}"), {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [
                                    {{ round($incorrectCount / $relatedCount * 100) }},
                                    {{ round($correctCount / $relatedCount * 100) }},
                                ],
                                backgroundColor: [
                                    '#EB1616',
                                    '#1d9f71',
                                ],
                            }],
                            labels: [
                                'Insecure',
                                'Secure'
                            ],
                        },
                    })
                </script>
            </div>
        @endforeach

        <div class="bg-secondary rounded py-3 px-4">

            @php
                $totalCount = $data->count();
                $unrelatedCount = $data->filter(function ($x) { return $x == Response::UNRELATED; })->count();
                $relatedCount = $totalCount - $unrelatedCount;
                $correctCount = $data->filter(function ($x) { return $x == Response::YES; })->count();
                $incorrectCount = $relatedCount - $correctCount;
            @endphp

            <h6 class="text-lg mt-4">Total Security Level: {{ floor($correctCount / $relatedCount * 100) }}%</h6>
            <canvas id="canvas_category_all" class="max-h-80"></canvas>
            <script>
                new Chart(document.querySelector("#canvas_category_all"), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [
                                {{ round($incorrectCount / $relatedCount * 100) }},
                                {{ round($correctCount / $relatedCount * 100) }},
                            ],
                            backgroundColor: [
                                '#EB1616',
                                '#1d9f71',
                            ],
                        }],
                        labels: [
                            'Insecure',
                            'Secure'
                        ],
                    },
                })
            </script>
            @php
                $incorrectIds = $data->filter(function ($x) { return $x == Response::UNRELATED; })->keys()->toArray();
                $advices = $questions->only($incorrectIds)->map(fn(Question $question) => $question->advice);
            @endphp

            <ul class="list-disc m-4">
                @foreach($advices as $advice)
                    <li class="pl-2 text-white">{{ $advice }}</li>
                @endforeach
            </ul>


        </div>
    </div>
@endsection
