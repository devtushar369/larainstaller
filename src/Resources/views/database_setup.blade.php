@extends('larainstaller::layout.master')
@section('page_title', 'Check Database Setup and Connection')
@section('menu_title', 'Database Setup')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Check Database Setup and Connection</h3>
        <form id="databaseSetupForm" action="{{ route('install.database_setup.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="database_host" class="form-label h6">Database Host<span class="text-danger fw-bold">*</span></label>
                <input type="text" id="database_host" class="form-control" value="{{ config('database.connections.mysql.host') }}" name="database_host" placeholder="127.0.0.1">
                @error('database_host')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="database_port" class="form-label h6">Database Port<span class="text-danger fw-bold">*</span></label>
                <input type="number" id="database_port" class="form-control" value="{{ config('database.connections.mysql.port') }}" name="database_port" placeholder="3306">
                @error('database_port')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="database_name" class="form-label h6">Database Name<span class="text-danger fw-bold">*</span></label>
                <input type="text" id="database_name" class="form-control" value="{{ config('database.connections.mysql.database') }}" name="database_name" placeholder="Database Name">
                @error('database_name')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="database_username" class="form-label h6">Database Username<span class="text-danger fw-bold">*</span></label>
                <input type="text" id="database_username" class="form-control" value="{{ config('database.connections.mysql.username') }}" name="database_username" placeholder="Database Username">
                @error('database_username')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="database_password" class="form-label h6">Database Password</label>
                <input type="password" id="database_password" class="form-control" value="{{ config('database.connections.mysql.password') }}" name="database_password" placeholder="Database password">
                @error('database_password')
                <div class="error text-danger form-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="hero-buttons mt-4 text-center">
                <button id="go-next-button" type="submit" class="btn btn-primary me-0 me-sm-2 mx-1">
                    <span id="text">Go to Next <i class="bi bi-arrow-right"></i></span>
                </button>
            </div>
        </form>
    </div>
@endsection
