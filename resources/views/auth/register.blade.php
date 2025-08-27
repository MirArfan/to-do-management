@extends('layouts.app')

@section('styles')
<style>
    .dark-mode {
  background-color: #121417 !important;
  color: #e9ecef !important;
}

.dark-mode .card {
  background-color: #1e1e2f;
  color: #f1f5f9;
  border: 1px solid #2f3842;
}

.dark-mode .card-header {
  background-color: #2a2f3e;
  color: #f8fafc;
}

.dark-mode label {
  color: #cbd5e1;
}

.dark-mode .form-control {
  background-color: #2d2d3f;
  color: #f8fafc;
  border-color: #3f4a5a;
}

.dark-mode .form-control:focus {
  background-color: #2d2d3f;
  color: #fff;
  border-color: #4c8bf7;
  box-shadow: none;
}

.dark-mode .btn-primary {
  background-color: #3b82f6;
  border-color: #3b82f6;
}

.dark-mode .btn-primary:hover {
  background-color: #2563eb;
  border-color: #2563eb;
}

.dark-mode .btn-link {
  color: #93c5fd;
}
.dark-mode .btn-link:hover {
  color: #bfdbfe;
}

</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card {{ $theme == 'dark' ? 'dark-mode' : '' }}">
                <div class="card-header ">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
