@extends("layouts.project")

@section("project")

    <div class="container-fluid h-full">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">

                    <form method="POST" action="{{ route("projects.reports.store", $project) }}">
                        @csrf

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3>Create a new report</h3>
                        </div>

                        <div class="form-floating mb-3">
                            <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    id="inputEmail"
                                    placeholder="Email"
                                    value="{{ old("email") }}"
                            />
                            <label for="inputEmail">Email</label>

                            @error("email")
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Create Report</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
