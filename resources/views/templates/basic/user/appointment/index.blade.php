@extends('Template::layouts.master')

@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-body">
                    <form action="#" class="appointment-form">
                        <div class="form-group flex-grow-1">
                            <label class="form--label">@lang('Email/Mobile/Unique Id')</label>
                            <input type="text" name="search" placeholder="@lang('Search')" value="{{ request()->search }}" class="form--control">
                        </div>
                        <div class="form-group flex-grow-1">
                            <label for="date" class="form--label">@lang('Date')</label>
                            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en"
                                class="date form--control" data-position='bottom right' placeholder="@lang('Start date - End date')" autocomplete="off"
                                value="{{ request()->date }}">
                        </div>
                        <div class="form-group flex-grow-1">
                            <label for="status" class="form--label">@lang('Status')</label>
                            <select name="status" class="form-select form--control">
                                <option value="">@lang('All')</option>
                                <option value="{{ Status::UPCOMING_APPOINTMENT }}" @if (request()->status == Status::UPCOMING_APPOINTMENT) selected @endif>
                                    @lang('Upcoming')</option>
                                <option value="{{ Status::COMPLETED_APPOINTMENT }}" @if (request()->status == Status::COMPLETED_APPOINTMENT) selected @endif>
                                    @lang('Complete')</option>
                                <option value="{{ Status::CANCELLED_APPOINTMENT }}" @if (request()->status == Status::CANCELLED_APPOINTMENT) selected @endif>
                                    @lang('Cancelled')</option>
                            </select>
                        </div>
                        <div class="filterBtn flex-grow-1 align-self-end">
                            <button class="btn btn--base w-100 btn--lg" type="submit"> <span class="btn-icon"><i
                                        class="las la-filter"></i></span>@lang('Filter')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="custom--card card dashboard-table">
                <div class="card-body">
                    <table class="table table--responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Name') | @lang('Appointment ID')</th>
                                <th>@lang('Mobile') | @lang('Email')</th>
                                <th>@lang('Date') | @lang('Time')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>{{ $loop->index + $appointments->firstItem() }}</td>
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
                                    <td>
                                        @php
                                            echo @$appointment->appointmentStatus;
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn--sm btn-outline--base" type="button" id="dropdownMenuButton{{ $loop->index }}"
                                                data-bs-toggle="dropdown">
                                                <i class="las la-ellipsis-v"></i> @lang('Action')
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->index }}">

                                                @php
                                                    $isDisabled = $appointment->status != Status::UPCOMING_APPOINTMENT;
                                                @endphp
                                                <li>
                                                    <button type="button" class="dropdown-item action-btn cuModalBtn"
                                                        data-modal_title="@lang('Update Appointment')" data-resource="{{ $appointment }}"
                                                        @disabled($isDisabled)>
                                                        <i class="las la-pen"></i>@lang('Edit')
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item action-btn confirmationBtn" data-status="2"
                                                        data-action="{{ route('user.appointment.status', $appointment->id) }}"
                                                        data-question="@lang('Are you sure to complete this appointment')?" @disabled($isDisabled)>
                                                        <i class="las la-check-double"></i> @lang('Complete')
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item action-btn confirmationBtn" data-status="3"
                                                        data-action="{{ route('user.appointment.status', $appointment->id) }}"
                                                        data-question="@lang('Are you sure to cancel this appointment')?" @disabled($isDisabled)>
                                                        <i class="lar la-times-circle"></i> @lang('Cancel')
                                                    </button>
                                                </li>
                                            </ul>
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
            
            @if ($appointments->hasPages())
                {{ paginateLinks($appointments) }}
            @endif

        </div>
    </div>

    <div class="custom--modal modal fade" id="cuModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('New Appointment')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.appointment.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Name')</label>
                                    <input type="text" class="form--control " name="name" value="{{ old('name') }}" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Age')</label>
                                    <div class="input-group">
                                        <input type="number" class="form--control" name="age" value="{{ old('age') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Gender')</label>
                                    <div class="input-group">
                                        <select class="form--control" name="gender">
                                            <option value="male" @selected(old('gender', @$appointment->gender) == 'male')>
                                                @lang('Male')
                                            </option>
                                            <option value="female" @selected(old('gender', @$appointment->gender) == 'female')>
                                                @lang('Female')
                                            </option>
                                            <option value="other" @selected(old('gender', @$appointment->gender) == 'other')>
                                                @lang('Other')
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Email')</label>
                                <div class="input-group">
                                    <input type="email" class="form--control" name="email" required value="{{ old('email') }}" />
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form--label">@lang('Phone')</label>
                                <div class="input-group">
                                    <input type="tel" class="form--control" name="mobile" value="{{ old('mobile') }}" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Appointment Date')</label>
                                    <div class="input-group">
                                        <input type="date" class="form--control" name="appointment_date" value="{{ @$appointmentDate }}"
                                            required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Appointment Time')</label>
                                    <div class="input-group">
                                        <input type="time" class="form--control" name="appointment_time" value="{{ old('appointment_time') }}"
                                            required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="custom--modal modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="question"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn--sm" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--base btn--sm">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--base cuModalBtn addBtn btn--sm" data-modal_title="@lang('New Appointment')">
        <i class="las la-plus"></i>@lang('New Appointment')
    </button>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/cuModal.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ getImage($activeTemplateTrue . 'css/datepicker.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ getImage($activeTemplateTrue . 'js/datepicker.min.js') }}"></script>
    <script src="{{ getImage($activeTemplateTrue . 'js/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            let appointmentDate = "{{ request()->appointment_date }}";
            if (appointmentDate) {
                setTimeout(() => {
                    $("#cuModal").modal('show');

                    var now = new Date("{{ request()->appointment_date }}");
                    var day = ("0" + now.getDate()).slice(-2);
                    var month = ("0" + (now.getMonth() + 1)).slice(-2);
                    var date = now.getFullYear() + "-" + (month) + "-" + (day);
                    $(`input[name=appointment_date]`).val(date);
                }, 200);
            }

            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                modal.find('form').append(`<input type="hidden" name="status" value="${data.status}">`);

                modal.modal('show');
            });

            $('#confirmationModal form').on('submit', function() {
                $('#confirmationModal').modal('hide');
            });

            $(".date").datepicker();

        })(jQuery);
    </script>
@endpush
@push('style')
    <style>
        .appointment-form-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            border-bottom: 1px solid hsl(var(--black) / .09);
            padding-bottom: 20px;
        }

        .card-header__title {
            margin-bottom: 40px;
        }

        @media screen and (max-width: 991px) {
            .appointment-form-wrapper {
                flex-direction: column;
                gap: 16px;
            }
        }
    </style>
@endpush
