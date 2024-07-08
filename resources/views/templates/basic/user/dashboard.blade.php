@extends('Template::layouts.master')
@section('content')
<div class="notice"></div>
    <div class="row gy-3">
        <div class="col-xxl-4 col-sm-6">
            <div class="dashboard-widget flex-between">
                <div class="dashboard-widget__content">
                    <span class="title">@lang('Appointment Completed')</span>
                    <h3 class="number">{{ getAmount($completed) }}</h3>
                </div>
                <span class="dashboard-widget__icon flex-center">
                    <i class="icon-save-cost"></i>
                </span>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6">
            <div class="dashboard-widget flex-between">
                <div class="dashboard-widget__content">
                    <span class="title">@lang('Upcoming Appointment')</span>
                    <h3 class="number">{{ getAmount($upcoming) }}</h3>
                </div>
                <span class="dashboard-widget__icon flex-center">
                    <i class="icon-promotion"></i>
                </span>
            </div>
        </div>
        @if (auth()->user()->is_staff)
            <div class="col-xxl-4 col-sm-6">
                <div class="dashboard-widget flex-between">
                    <div class="dashboard-widget__content">
                        <span class="title">@lang('Cancelled Appointment')</span>
                        <h3 class="number">{{ getAmount($cancelled) }}</h3>
                    </div>
                    <span class="dashboard-widget__icon flex-center">
                        <i class="icon-close"></i>
                    </span>
                </div>
            </div>
        @endif

        <div class="col-xxl-4 col-sm-6">
            <div class="dashboard-widget flex-between">
                <div class="dashboard-widget__content">
                    <span class="title">@lang('Total Clients')</span>
                    <h3 class="number">{{ getAmount($total) }}</h3>
                </div>
                <span class="dashboard-widget__icon flex-center">
                    <i class="icon-subscription-member"></i>
                </span>
            </div>
        </div>

        <div class="col-xxl-4 col-sm-6">
            <div class="dashboard-widget flex-between">
                <div class="dashboard-widget__content">
                    <span class="title">@lang('Today Remaining')</span>
                    <h3 class="number">{{ getAmount($todayRemaining) }}</h3>
                </div>
                <span class="dashboard-widget__icon flex-center">
                    <i class="icon-calendar-03"></i>
                </span>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6">
            <div class="dashboard-widget flex-between">
                <div class="dashboard-widget__content">
                    <span class="title">@lang('This Month Remaining')</span>
                    <h3 class="number">{{ getAmount($thisMonthRemaining) }}</h3>
                </div>
                <span class="dashboard-widget__icon flex-center">
                    <i class="icon-report"></i>
                </span>
            </div>
        </div>
        @if (!auth()->user()->is_staff)
            <div class="col-xxl-4 col-sm-6">
                <div class="dashboard-widget flex-between">
                    <div class="dashboard-widget__content">
                        <span class="title">@lang('Staff Remaining')</span>
                        <h3 class="number">{{ getAmount($staffRemaining) }}</h3>
                    </div>
                    <span class="dashboard-widget__icon flex-center">
                        <i class="icon-users"></i>
                    </span>
                </div>
            </div>
        @endif
    </div>
    <h5 class="my-5">@lang('Upcoming Appointment')</h5>
    <div class="dashboard-bottom">
        <div class="custom--card card dashboard-table h-100">
            <div class="card-body h-100">
                <table class="table table--responsive--md">
                    <thead>
                        <tr>
                            <th>@lang('Name') | @lang('Appointment ID')</th>
                            <th>@lang('Mobile') | @lang('Email')</th>
                            <th>@lang('Date') | @lang('Time')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>
                                    <div>
                                        {{ __(@$appointment->name) }} <br>
                                        <small class="fs-14">
                                            {{ @$appointment->unique_id }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a href="tel:{{ @$appointment->mobile }}">{{ @$appointment->mobile }}</a> <br>
                                        <a class="fs-14" href="mailto:{{ @$appointment->email }}">{{ @$appointment->email }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ showDateTime(@$appointment->appointment_date, 'Y-m-d') }} <br>
                                        <span class="fs-14">
                                            {{ showDateTime(@$appointment->appointment_time, 'h:i A') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-empty-message />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="appointment-calendar-wrapper">
            <div id="appointment_calendar" class="appointment_calendar"></div>
        </div>
        <form id="appointmentForm" action="{{ route('user.appointment.index') }}" method="GET">
            <input type="hidden" name="appointment_date" id="appointment_date">
        </form>
    </div>
@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{ getImage($activeTemplateTrue . 'css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ getImage($activeTemplateTrue . 'css/jsRapCalendar.css') }}">
@endpush

@push('script-lib')
    <script src="{{ getImage($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
    <script src="{{ getImage($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
    <script src="{{ getImage($activeTemplateTrue . 'js/jsRapCalendar.js') }}"></script>
@endpush


@push('style')
    <style>
        .dashboard .dashboard-table {
            width: calc(100% - 525px);
        }

        @media (max-width: 1799px) {
            .dashboard .dashboard-table {
                width: 100%;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        $(".datepicker-here").datepicker();
        (function($) {
            "use strict"
            $('#appointment_calendar').jsRapCalendar({
                week: 6,
                enabled: true,
                showCaption: true,
                showArrows: true,
                showYear: true,
                daysName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthsNames: ['January', 'February', 'March', 'April', 'May', 'Jun', 'July', 'August',
                    'September', 'October',
                    'November', 'December'
                ],
                onClick: function(y, m, d) {
                    m = m + 1;
                    $('#appointment_date').val(y + '-' + m + '-' + d);
                    $('#appointmentForm').submit();
                }
            });

        })(jQuery);
    </script>
@endpush
