@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Price')(@lang('Monthly')- @lang('Yearly'))</th>
                                    <th>@lang('Appointment Limit')(@lang('Daily')- @lang('Monthly'))</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pricing as $pricing)
                                    <tr>
                                        <td>{{ __($pricing->name) }}</td>
                                        <td>
                                            <div>
                                                {{ showAmount($pricing->monthly_price) }}<br>
                                                {{ showAmount($pricing->yearly_price) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ getAmount($pricing->daily_appointment_limit) }} <br>
                                                {{ getAmount($pricing->monthly_appointment_limit) }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                echo $pricing->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">

                                                <button class="btn btn-outline--primary cuModalBtn btn-sm"
                                                    data-modal_title="@lang('Update Pricing')" data-resource="{{ $pricing }}">
                                                    <i class="las la-pen"></i>@lang('Edit')
                                                </button>

                                                @if ($pricing->status == Status::DISABLE)
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                        data-question="@lang('Are you sure to enable this pricing plan')?"
                                                        data-action="{{ route('admin.pricing.status', $pricing->id) }}">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                        data-question="@lang('Are you sure to disable this pricing plan')?"
                                                        data-action="{{ route('admin.pricing.status', $pricing->id) }}">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>

    <div class="modal fade" id="cuModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cuModal"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.pricing.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row">
                        <div class="form-group col-sm-12">
                            <label>@lang('Pricing Name')</label>
                            <input type="text" class="form-control " name="name" value="{{ old('name') }}"
                                required />
                        </div>
                        <div class="form-group col-sm-12">
                            <label>@lang('Monthly Price')</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                <input type="number" step="any" class="form-control" name="monthly_price" required
                                    value="{{ old('monthly_price') }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>@lang('Yearly Price')</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ gs('cur_sym') }}</span>
                                <input type="number" step="any" class="form-control" name="yearly_price" required
                                    value="{{ old('yearly_price') }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>@lang('Appointment Daily Limit')</label>
                            <div class="input-group">
                                <span class="input-group-text">@lang('Daily')</span>
                                <input type="number" step="any" class="form-control" name="daily_appointment_limit"
                                    required value="{{ old('daily_appointment_limit') }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>@lang('Appointment Monthly Limit')</label>
                            <div class="input-group">
                                <span class="input-group-text">@lang('Monthly')</span>
                                <input type="number" step="any" class="form-control" name="monthly_appointment_limit"
                                    required value="{{ old('monthly_appointment_limit') }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>@lang('Staff Limit')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control" name="staff_limit" required
                                    value="{{ old('staff_limit') }}" />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection


@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary cuModalBtn addBtn" data-modal_title="@lang('Add Pricing')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/cuModal.js') }}"></script>
@endpush
