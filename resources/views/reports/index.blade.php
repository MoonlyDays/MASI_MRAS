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
                    <td>
                        <a href="{{ route("reports.show", $report) }}">
                            <button type="button" class="btn btn-light text-nowrap flex items-center gap-1">
                                @svg('bi-eye-fill') View Report
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="flex">
            <a href="{{ route("projects.reports.create", $project) }}">
                <button type="button" class="btn btn-primary flex items-center gap-1">
                    @svg('tabler-report-analytics') Create Report
                </button>
            </a>
        </div>

    </div>
@endsection
