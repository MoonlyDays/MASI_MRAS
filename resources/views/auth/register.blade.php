@extends("layouts.core")

@section("content")

    <!-- Sign Up Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">

                    <form method="POST">
                        @csrf

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Glitch&Grind</h3>
                            <h3>Sign Up</h3>
                        </div>


                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old("name") }}"
                            >
                            <label>Username</label>

                            @error("name")
                            <div class="error">{{ $message }}</div>
                            @enderror

                        </div>


                        <div class="form-floating mb-3">
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                value="{{ old("password") }}"
                            >
                            <label>Password</label>

                            @error("password")
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                value="{{ old("password_confirmation") }}"
                            >
                            <label>Confirm Password</label>

                            @error("password_confirmation")
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                >
                                <label class="form-check-label">Check me out</label>
                            </div>
                            <a href="">Forgot Password</a>
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                        <p class="text-center mb-0">Already have an Account? <a href="{{ route("login") }}">Sign In</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up End -->

@endsection
