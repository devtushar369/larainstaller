@extends('larainstaller::layout.master')
@section('page_title', 'Check Permissions')
@section('menu_title', 'Check Permissions')
@section('content')
    <div class="mt-3">
        <h3 class="mb-4">Check Folders Permission</h3>
        <div class="row">
            @php $failed = 0 @endphp
            @foreach($requirements ?? [] as $req)
                <div class="col-lg-6 mb-3">
                    <div class="bg-white p-3 rounded-3 shadow-sm  d-flex justify-content-between align-items-center ">
                        <h6>{{ $req['title'] }}</h6>
                        <span>
                        @if ($req['value'] == true)
                                <i class="bi bi-check-circle-fill text-success"></i> 755
                            @else
                                @php $failed += 1 @endphp
                                <i class="bi bi-ban-fill text-danger"></i> 755
                            @endif
                    </span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="hero-buttons mt-4 text-center">
            @if($failed < 1)
                <a href="{{ route('install.license_verification') }}" id="goNext"
                   class="btn btn-primary me-0 me-sm-2 mx-1">
                    Go to Next <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <a href="{{ url()->current() }}" class="btn btn-primary me-0 me-sm-2 mx-1">
                    Reload <i class="bi bi-repeat"></i>
                </a>
            @endif
        </div>
    </div>
@endsection
