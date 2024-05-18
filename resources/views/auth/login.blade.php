@extends("layouts.auth")

@section("auth")

    <form method="POST">
        @csrf

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="text-primary text-3xl">
                <i class="fa fa-user-edit me-2"></i>{{ config("app.name") }}
            </h3>
            <h3>Sign In</h3>
        </div>

        <div class="form-floating mb-3">
            <input
                    type="text"
                    name="name"
                    class="form-control"
                    id="floatingUsername"
                    placeholder="Username"
                    value="{{ old("name") }}"
            />
            <label for="floatingUsername">Username</label>

            @error("name")
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-4">
            <input
                    type="password"
                    name="password"
                    class="form-control"
                    id="floatingPassword"
                    placeholder="Password"
                    value="{{ old("password") }}"
            />
            <label for="floatingPassword">Password</label>

            @error("password")
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input
                        type="checkbox"
                        name="remember"
                        class="form-check-input"
                        id="inputRemember"
                />
                <label class="form-check-label" for="inputRemember">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
        <p class="text-center mb-0">
            Don't have an Account? <a href="{{route("register")}}">Sign Up</a>
        </p>
    </form>
@endsection
