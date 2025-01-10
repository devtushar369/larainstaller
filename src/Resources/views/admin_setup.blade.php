@extends('larainstaller::layout.master')
@section('page_title', 'Admin Setup')
@section('menu_title', 'Admin Setup')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Admin Setup</h3>
        <form id="adminSetup" action="{{ route('install.admin_setup.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label h6">Email<span class="text-danger fw-bold">*</span></label>
                <input type="email" id="email" class="form-control" value="" name="email" placeholder="Enter email">
                @error('email')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="form-label h6">Password<span class="text-danger fw-bold">*</span></label>
                <input type="password" id="password" class="form-control" value="" name="password"
                       placeholder="Enter Password">
                @error('password')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="form-label h6">Password Confirmation<span
                        class="text-danger fw-bold">*</span></label>
                <input type="password" id="password_confirmation" class="form-control" value=""
                       name="password_confirmation" placeholder="Enter Password">
                @error('password_confirmation')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input name="demo_data" type="hidden" value="0">
                </div>
            </div>

            <div class="hero-buttons mt-4 text-center">
                <button id="go-next-button" type="submit" class="btn btn-primary me-0 me-sm-2 mx-1">
                    <span id="text">Go to Next <i class="bi bi-arrow-right"></i></span>
                </button>
            </div>
        </form>
    </div>
@endsection
