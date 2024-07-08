@extends('Template::layouts.frontend')
@section('content')
    @include('Template::partials.breadcrumb')
    <div class="container recovery-account-wrapper py-110">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h3 class="text-center text-danger">@lang('YOU ARE BANNED')</h3>
                    <p class="fw-bold mb-1">@lang('Reason'):</p>
                    <p class="mb-3">{{ $user->ban_reason }}</p>
                    <a href="{{route('home')}}" class="btn btn--base">@lang('Home')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        body {
            justify-content: center;
            align-items: center;
        }

        header,
        footer,
        .breadcrumb {
            display: none;
        }
    </style>
@endpush
