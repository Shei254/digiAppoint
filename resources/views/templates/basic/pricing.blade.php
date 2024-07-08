@extends('Template::layouts.frontend')
@section('content')
    @include('Template::partials.breadcrumb')
    <section class="pricing-section mt-5 pb-110">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    @if (!$pricing->isEmpty())
                        <div class="text-center">
                            <ul class="custom--tab nav nav-pills pricing-tabs">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill time-tab active" data-time="monthly" id="monthly-tab" data-bs-toggle="pill"
                                        data-bs-target="#monthly" type="button" role="tab">@lang('Monthly')</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link rounded-pill time-tab" id="yearly-tab" data-time="yearly" data-bs-toggle="pill"
                                        data-bs-target="#yearly" type="button" role="tab"
                                        tabindex="-1">@lang('Yearly')</button>
                                </li>
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
            <div class="row justify-content-center g-3">
                <div class="col-xl-10">
                    <div class="row justify-content-center gy-4">
                        @include('Template::partials.pricing')
                    </div>
                </div>
            </div>
        </div>
    </section>


    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection
