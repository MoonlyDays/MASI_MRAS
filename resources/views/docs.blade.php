@extends("layouts.dashboard")

@section("page")
    <div class="p-4">
        <div class="bg-secondary p-4">
            {!! Str::markdown($content) !!}
        </div>
    </div>
@endsection