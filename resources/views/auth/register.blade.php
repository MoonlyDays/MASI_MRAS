@extends("layouts.auth")

@section("auth")

    <form method="POST">
        @csrf

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="text-primary font-black text-3xl flex gap-2 items-center">
                <img src="{{ Vite::asset("resources/img/icon.png") }}" width="48" alt=""/>
                {{ config("app.name") }}
            </div>
            <h3>Sign Up</h3>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                name="name"
                id="inputName"
                class="form-control"
                placeholder="Username"
                value="{{ old("name") }}"
            >
            <label for="inputName">Username</label>

            @error("name")
            <div class="text-primary">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-floating mb-3">
            <input
                type="password"
                name="password"
                id="inputPassword"
                class="form-control"
                placeholder="Username"
                value="{{ old("password") }}"
            >
            <label for="inputPassword">Password</label>

            @error("password")
            <div class="text-primary">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-4">
            <input
                type="password"
                name="password_confirmation"
                id="inputPasswordConfirmation"
                class="form-control"
                placeholder="Confirm Password"
                value="{{ old("password_confirmation") }}"
            >
            <label for="inputPasswordConfirmation">Confirm Password</label>

            @error("password_confirmation")
            <div class="text-primary">{{ $message }}</div>
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

        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
        <p class="text-center mb-0">Already have an Account? <a href="{{ route("login") }}">Sign In</a>
        </p>
    </form>

@endsection
