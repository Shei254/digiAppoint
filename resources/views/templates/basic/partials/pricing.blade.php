@foreach ($pricing as $key => $pricing)
    <div class="col-xl-3 col-lg-4 col-sm-6 d-none">
        <div class="pricing-item">
            <div class="pricing-item__heading">
                <h5 class="pricing-item__category">{{ __(strtoupper(@$pricing->name)) }}</h5>
                <h4 class="pricing-item__price monthly-price">
                    {{ showAmount(@$pricing->monthly_price) }} <sub>/@lang('month')</sub></h4>

                <h4 class="pricing-item__price yearly-price">
                    {{ showAmount(@$pricing->yearly_price) }} <sub>/ @lang('yearly')</sub></h4>

            </div>
            <div class="pricing-item__content">
                <ul class="pricing-item__list">
                    <li class="pricing-item__item">@lang('Staff add limit'):
                        {{ getAmount(@$pricing->staff_limit) }}</li>
                    <li class="pricing-item__item">@lang('Daily appointment'):
                        {{ getAmount(@$pricing->daily_appointment_limit) }}</li>
                    <li class="pricing-item__item">@lang('Monthly appointment'):
                        {{ getAmount(@$pricing->monthly_appointment_limit) }}</li>
                </ul>
                @guest
                    <a href="{{ route('user.login') }}" class="btn btn-outline--base">@lang('Subscribe Now')</a>
                @else
                    @if(\Auth::user()->awsCustomer)
                        <a href="#"
                           class="btn btn-outline--base subscribeBtn">@lang('Billing Handled By Aws')</a>
                    @else
                        <a href="{{ route('user.deposit.index', ['pricing_id' => $pricing->id, 'time' => ':placeholderTime']) }}"
                           class="btn btn-outline--base subscribeBtn">@lang('Subscribe Now')</a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-6 col-xsm-6">
        <div class="pricing-card">
            <div class="pricing-card__header">
                <h5 class="pricing-card__title"> {{ __(strtoupper(@$pricing->name)) }} </h5>
            </div>
            <ul class="pricing-item__list">
                <li class="pricing-item__item">@lang('Staff Limit'):
                    {{ getAmount(@$pricing->staff_limit) }}</li>
                <li class="pricing-item__item">@lang('Daily Appointment Limit'):
                    {{ getAmount(@$pricing->daily_appointment_limit) }}</li>
                <li class="pricing-item__item">@lang('Monthly Appointment Limit'):
                    {{ getAmount(@$pricing->monthly_appointment_limit) }}</li>
            </ul>
            <div class="pricing-card__right">
                <h4 class="pricing-item__price monthly-price">
                    {{ showAmount(@$pricing->monthly_price) }}
                    <sub>/@lang('Month')</sub></h4>

                <h4 class="pricing-item__price yearly-price">
                    {{ showAmount(@$pricing->yearly_price) }}
                    <sub>/ @lang('Year')</sub></h4>
                @guest
                    <a href="{{ route('user.login') }}" class="btn btn-outline--base btn--sm">@lang('Subscribe Now')</a>
                @else
                    @if(\Auth::user()->awsCustomer)
                        <a href="#"
                           class="btn btn-outline--base subscribeBtn btn--sm">@lang('Billing handled by aws')</a>
                    @else
                        <a href="{{ route('user.deposit.index', ['pricing_id' => $pricing->id, 'time' => ':placeholderTime']) }}"
                           class="btn btn-outline--base subscribeBtn btn--sm">@lang('Subscribe Now')</a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
@endforeach


@push('style')
    <style>
        .yearly-price {
            display: none
        }

        .custom--tab {
            background-color: hsl(var(--white)) !important;
            border: 1px solid hsl(var(--base));
            border-radius: 50px;
            width: auto;
            display: inline-flex;
            margin-bottom: 48px;
            position: relative;
            z-index: 1;
        }

        .custom--tab .nav-item .nav-link.active {
            color: hsl(var(--white));
            background-color: hsl(var(--base)) !important;
            border: 1px solid transparent !important;
        }

        .pricing-item__list {
            margin-bottom: 0;
            padding: 10px 0;
            margin-left: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .custom--tab .nav-item .nav-link {
            color: hsl(var(--base));
            padding: 8px 25px !important;
            background-color: transparent !important;
            border-radius: 5px;
            transition: 0.4s f;
            border: 1px solid hsl(var(--white)) !important;
        }

        .pricing-item__price {
            color: hsl(var(--black)) !important;
            margin-bottom: 15px;
        }

        .pricing-item__list {
            margin-bottom: 0;
        }


        .pricing-card {
            display: grid;
            grid-template-columns: 1fr 2fr 2fr;
            border: 1px solid hsl(var(--black)/.1);
            border-radius: 6px;
            overflow: hidden;
        }

        .pricing-card__header {
            background: hsl(var(--base)/0.75);
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pricing-card__right {
            text-align: right;
            padding: 15px 30px;
        }

        @media (max-width:767px) {
            .pricing-card {
                display: block;
            }

            .pricing-item__list {
                margin-left: 0;
                padding: 0 10px;
                margin-top: 15px;
                align-items: start;
            }


            .pricing-card__header {
                padding: 30px 20px;
            }

            .pricing-card__right {
                text-align: center;
                padding: 0 10px;
                margin: 15px 0;
            }
        }

        .pricing-card__title {
            color: hsl(var(--white));
        }


        .pricing-card__header.bg-img {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pricing-card__title.h3 {}
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {

            $('#monthly-tab').on('click', function() {
                $('.monthly-price').show();
                $('.yearly-price').hide();
                setPriceTime();
            });

            $('#yearly-tab').on('click', function() {
                $('.monthly-price').hide();
                $('.yearly-price').show();
                setPriceTime();
            });

            setPriceTime()

            function setPriceTime() {

                $.each($('.subscribeBtn'), function(indexInArray, btnElement) {

                    btnElement = $(btnElement);
                    btnHref = btnElement.attr('href');
                    btnHref = btnHref.replace(':placeholderTime', $('.time-tab.active').data('time'));
                    btnHref = btnHref.replace('monthly', $('.time-tab.active').data('time'));
                    btnHref = btnHref.replace('yearly', $('.time-tab.active').data('time'));

                    btnElement.attr('href', btnHref)

                });
            }
        });
    </script>
@endpush
