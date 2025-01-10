@extends('larainstaller::layout.master')
@section('page_title', 'Please Verification your License')
@section('menu_title', 'License Verification')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Please verification your license</h3>
        <form id="licenseForm" action="{{ route('install.license_verification.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="access_code" class="form-label h6">Access Code <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="access_code" class="form-control" name="access_code" placeholder="Access Code">
                @error('access_code')
                    <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
                <h6 class="mt-2 form-text"><i class="bi bi-info-circle"></i> Enter your purchase code to verify your license</h6>
            </div>
            <div class="mb-4">
                <label for="envato_email" class="form-label h6">Envato Email <span class="text-danger fw-bold">*</span></label>
                <input type="email" id="envato_email" class="form-control" name="envato_email" placeholder="Envato Email">
                @error('envato_email')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
                <h6 class="mt-2 form-text"><i class="bi bi-info-circle"></i> To verify your authorization, use your Envato account
                    email address</h6>
            </div>
            <div class="mb-4">
                <label for="installed_domain" class="form-label h6">Installed Domain <span class="text-danger fw-bold">*</span></label>
                <input type="url" id="installed_domain" class="form-control" value="{{ config('app.url') }}" name="domain" placeholder="Installed Domain">
                @error('domain')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
                <h6 class="mt-2 form-text"><i class="bi bi-info-circle"></i> What domain or subdomain are you using to access this
                    project? This will depend on whether you want to install the project on the main domain (e.g.,
                    example.com) or a subdomain (e.g., sub.example.com).</h6>
            </div>

            <div class="hero-buttons mt-4 text-center">
                <button type="submit" class="btn btn-primary me-0 me-sm-2 mx-1">
                    <span id="text">Go to Next <i class="bi bi-arrow-right"></i></span>
                </button>
            </div>
        </form>
    </div>
@endsection
