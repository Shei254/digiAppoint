@php
    $pricingContent = @getContent('pricing.content', true)->data_values;
    $pricing = App\Models\Pricing::active()->orderBy('monthly_price', 'asc')->get();
@endphp

<section class="pricing-section pb-110">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title" data-s-break="1">{{ __(@$pricingContent->heading) }} </h2>
                    <p>{{ __(@$pricingContent->subheading) }}</p>
                </div>
            </div>
        </div>
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
            @include('Template::partials.pricing')
        </div>
    </div>
</section>
