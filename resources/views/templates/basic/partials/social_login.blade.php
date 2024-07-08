@php
    $credentials = gs()->socialite_credentials;
@endphp

@if (
    $credentials->google->status == Status::ENABLE ||
        $credentials->facebook->status == Status::ENABLE ||
        $credentials->linkedin->status == Status::ENABLE)
    <div class="col-12">
        <div class="other-option">
            <span class="other-option__text">@lang('OR')</span>
        </div>
        <div class="d-flex flex-wrap gap-3">
            @if ($credentials->facebook->status == Status::ENABLE)
                <a href="{{ route('user.social.login', 'facebook') }}" class="btn btn-outline-facebook btn-sm flex-grow-1">
                    <span class="me-1"><i class="la la-facebook"></i></span>
                    @lang('Facebook')
                </a>
            @endif
            @if ($credentials->google->status == Status::ENABLE)
                <a href="{{ route('user.social.login', 'google') }}" class="btn btn-outline-google btn-sm flex-grow-1">
                    <span class="me-1"><i class="lab la-google"></i></span>
                    @lang('Google')
                </a>
            @endif
            @if ($credentials->linkedin->status == Status::ENABLE)
                <a href="{{ route('user.social.login', 'linkedin') }}" class="btn btn-outline-linkedin btn-sm flex-grow-1">
                    <span class="me-1"><i class="la la-linkedin"></i></span>
                    @lang('Linkedin')
                </a>
            @endif
        </div>
    </div>
@endif

@push('style')
    <style>
        .btn-outline-facebook {
            border-color: #395498;
            background-color: transparent;
            color: #395498 !important;
        }

        .btn-outline-facebook:hover {
            border-color: #395498;
            color: #fff !important;
            background-color: #395498;
        }

        .me-1 {
            margin-right: .25rem !important;
        }

        .btn-outline-google {
            border-color: #D64937;
            background-color: transparent;
            color: #D64937 !important;
        }

        .btn-outline-google:hover {
            border-color: #D64937;
            color: #fff !important;
            background-color: #D64937;
        }

        .btn-outline-linkedin {
            border-color: #0077B5;
            background-color: transparent;
            color: #0077B5 !important;
        }

        .btn-outline-linkedin:hover {
            border-color: #0077B5;
            color: #fff !important;
            background-color: #0077B5;
        }
    </style>
@endpush
