@php
    use App\Models\Project;
    /** @var Project $project */
@endphp


@extends("layouts.dashboard")

@section("page")

    <div class="container-fluid h-full">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">

                    <form method="POST" action="{{ route("projects.update", $project) }}">
                        @csrf
                        @method("PUT")

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3>Edit Project</h3>
                        </div>

                        <div class="form-floating mb-3">
                            <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    id="inputTitle"
                                    placeholder="Project Title"
                                    value="{{ old("title", $project->title) }}"
                            />
                            <label for="inputTitle">Project Title</label>

                            @error("title")
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Edit Project</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection