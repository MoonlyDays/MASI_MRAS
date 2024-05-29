@extends("layouts.dashboard")

@section("page")
    <div class="p-4">
        <div class="text-white font-bold text-4xl flex gap-3 items-center mb-2">
            <div>{{ $project->title }}</div>
            <a href="{{ route("projects.edit", $project) }}">
                @svg('ri-pencil-fill', 'w-6 text-primary')
            </a>
        </div>
        <div class="gap-2 mb-4">
            <div class="flex items-center gap-2 font-bold">
                <a href="{{ route("projects.show", $project) }}">
                    <button type="button" class="btn btn-outline-primary flex items-center gap-1">
                        @svg('tabler-report-analytics') Survey
                    </button>
                </a>
                <a href="{{ route("projects.reports.index", $project) }}">
                    <button type="button" class="btn btn-outline-primary flex items-center gap-1">
                        @svg('tabler-report-analytics') Reports
                    </button>
                </a>
            </div>
        </div>

        @yield("project")
    </div>
@endsection
