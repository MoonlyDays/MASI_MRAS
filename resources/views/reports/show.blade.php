@php
    use App\Models\Report;
    use App\Models\Response;
    /** @var Report $report */

    $answerDisplay = ['', 'Yes', 'No', 'Unrelated'];

@endphp

@extends("layouts.project")

@section("project")

    <div class="grid grid-cols-1 gap-6">

        <div class="bg-secondary rounded py-3 px-4 mb-2">
            <h6 class="text-xl">Report generated from {{ $report->created_at->toDateTimeString() }}</h6>
        </div>

        @foreach($report->categories() as $category)
            <div class="bg-secondary rounded py-3 px-4">
                <h6 class="mb-4 text-xl">{{ $category->title }}</h6>
                @php($stats = $report->statsFor($category))

                <table class="table">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stats["listings"] as $listing)
                        <tr @class(["opacity-30" => $listing['answer'] == Response::UNRELATED])>
                            <td> {{ $listing['question'] }}</td>
                            <td class="{{ $listing['color'] }}"> {!! $answerDisplay[$listing['answer']] !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($stats["related_count"] > 0)
                    <canvas id="canvas_category_{{ $category->id }}" class="max-h-64"></canvas>
                    <script>
                        new Chart(document.querySelector("#canvas_category_{{ $category->id }}"), {
                            type: 'doughnut',
                            data: {
                                datasets: [{
                                    data: [
                                        {{ 100 - $stats["secure_percent"] }},
                                        {{ $stats["secure_percent"] }},
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
                @endif

                <ul class="list-disc m-4">
                    @foreach($stats['advices'] as $advice)
                        <li class="pl-2 ">{{ $advice }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <div class="bg-secondary rounded py-3 px-4">

            @php($stats = $report->statsFor(null))
            <h6 class="text-lg">
                Total Security Level: {{ $stats["secure_percent"] }}%
            </h6>

            @if($stats["related_count"] > 0)
                <canvas id="canvas_category_all" class="max-h-80"></canvas>
                <script>
                    new Chart(document.querySelector("#canvas_category_all"), {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [
                                    {{ 100 - $stats["secure_percent"] }},
                                    {{ $stats["secure_percent"] }},
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
            @endif

            <div class="flex justify-center mt-4 w-full">
                <img src="{{ $cat }}" width="300"/>
            </div>
        </div>
    </div>
@endsection
