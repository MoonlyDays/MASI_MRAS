@php
    use App\Models\Report;
    use App\Models\Project;
    use Illuminate\Database\Eloquent\Collection;
    /** @var Collection<Report> $categories */
    /** @var Project $project */
@endphp

@extends("layouts.project")

@section("project")

    <!-- Table Start -->
    <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Reports for {{ $project->title }}</h6>
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col" class="w-full">Title</th>
                <th scope="col" class="whitespace-nowrap">Security Level</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($project->reports as $report)
                <tr>
                    <th class="align-middle" scope="row">
                        #{{ $loop->index + 1 }}
                    </th>
                    <td class="align-middle">
                        Report generated at {{ $report->created_at->toDateTimeString() }}
                    </td>
                    <td class="align-middle">
                        {{ $report->percent }}%
                    </td>
                    <td class="flex gap-2">
                        <a href="{{ route("reports.show", $report) }}">
                            <button type="button" class="btn btn-light text-nowrap flex items-center gap-1">
                                @svg('bi-eye-fill') View Report
                            </button>
                        </a>
                        <a href="{{ route("reports.download", $report) }}">
                            <button type="button" class="btn btn-light text-nowrap flex items-center gap-1">
                                @svg('ri-download-cloud-2-fill', "w-4")
                                Download
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="flex">
            @if($project->isCompleted())
                <a href="{{ route("projects.reports.create", $project) }}">
                    <button type="button" class="btn btn-primary flex items-center gap-1">
                        @svg('tabler-report-analytics') Create Report
                    </button>
                </a>
            @else
                <div>Please <a href="{{ route("projects.show", $project) }}">finish the survey</a> to generate a
                    report.
                </div>
            @endif
        </div>

    </div>
@endsection
