@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">{{ __('Verify Email') }}</div>

                <div class="card-body bg-light">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <p>We have sent an OTP to your email address. Please enter it below.</p>

                    <form method="POST" action="{{ route('auth.otp.verify', $userId) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="otp" class="form-label">{{ __('OTP') }}</label>
                            <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" required autofocus>
                            @error('otp')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-custom">
                            {{ __('Verify') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
