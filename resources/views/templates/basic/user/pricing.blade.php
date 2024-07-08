@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            @if (!$pricing->isEmpty())
                <div class="text-center">
                    <ul class="custom--tab nav nav-pills pricing-tabs">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill time-tab active" data-time="monthly" id="monthly-tab" data-bs-toggle="pill"
                                data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly"
                                aria-selected="true">@lang('Monthly')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill time-tab" id="yearly-tab" data-time="yearly" data-bs-toggle="pill"
                                data-bs-target="#yearly" type="button" role="tab" aria-controls="yearly" aria-selected="false"
                                tabindex="-1">@lang('Yearly')</button>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="row justify-content-center gy-4">
                @include('Template::partials.pricing')
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .pricing-card{
            background: hsl(var(--white));
            border:0;
        }
    </style>
@endpush