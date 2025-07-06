@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; background: linear-gradient(to right, #e6f0ff, #ffffff);">
    <div class="col-md-5">
        <div class="card shadow-lg border-0" style="border-radius: 20px;">
            <div class="card-header text-center" style="background-color: #0056b3; color: white; font-weight: bold; font-size: 1.5rem; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                👟 Selamat Datang di D'KATOS STORE Agus Setiawan
            </div>

            <div class="card-body px-4 py-4" style="background-color: #ffffff; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label text-primary fw-semibold">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control rounded-3 shadow-sm @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-primary fw-semibold">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control rounded-3 shadow-sm @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-secondary" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="text-decoration-none text-primary fw-medium" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4 text-muted small">
            &copy; {{ date('Y') }} D'KATOS. All rights reserved.
        </div>
    </div>
</div>
@endsection
