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
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
            </tr>
            </thead>
            <tbody>
            @foreach($project->reports as $report)
                <tr>
                    <th scope="row">{{ $loop->index }}</th>
                    <td>John</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route("projects.reports.create", $project) }}">
            <button type="button" class="btn btn-primary flex items-center gap-1">
                @svg('tabler-report-analytics') Create Report
            </button>
        </a>

    </div>
@endsection
