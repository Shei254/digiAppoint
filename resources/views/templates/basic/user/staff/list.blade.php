@extends('Template::layouts.master')
@section('content')
    <div class="custom--card card dashboard-table">
        <div class="card-body">
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('S.N.')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Mobile')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $staff)
                        <tr>
                            <td>{{ $loop->index + $staffs->firstItem() }}</td>
                            <td>{{ __(@$staff->full_name) }}</td>
                            <td>{{ @$staff->mobile }}</td>
                            <td>{{ @$staff->email }}</td>
                            <td>
                                @php
                                    echo @$staff->statusBadge;
                                @endphp
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('user.staff.profile', $staff->id) }}" class="btn btn-outline--success edit-btn btn--sm">
                                        <i class="la la-pencil"></i> @lang('Edit')
                                    </a>
                                    @if (@$staff->status == Status::USER_ACTIVE)
                                        <button type="button" class="btn btn-outline--danger btn--sm userStatus btnBtn" data-id="{{ $staff->id }}">
                                            <i class="las la-ban"></i> @lang('Ban Staff')
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline--warning btn--sm  unbanBtn" data-id="{{ @$staff->id }}"
                                            data-ban-reason="{{ @$staff->ban_reason }}">
                                            <i class="las la-undo"></i> @lang('Unban Staff')
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-empty-message />
                    @endforelse

                </tbody>
            </table>
            @if ($staffs->hasPages())
                <div class="card-footer">
                    {{ paginateLinks($staffs) }}
                </div>
            @endif
        </div>
    </div>

    <div id="userStatusModal" class="custom--modal modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <div>
                        <h5 class="modal-title mb-0">
                            @lang('Ban Staff')
                        </h5>
                        <span class="fs-14 ban-message">@lang('Banning this staff member will block their dashboard access.')</span>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="ban-message d-none form-group">
                            <div class="form-group">
                                <label class="form--label">@lang('Ban Reason')</label>
                                <textarea class="form--control" name="reason" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="ban-reson d-none form-group">
                            <div class="mb-3">
                                <p><span>@lang('Ban reason was'):</span></p>
                                <p class="ban-reason-message"></p>
                            </div>
                            <h6>@lang('Are you sure to unban this staff')?</h6>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--base  w-100">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-outline--base btn--sm" href="{{ route('user.staff.create') }}">
        <i class="las la-plus"></i>@lang('Add Staff')
    </a>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            $(".btnBtn").on("click", function(e) {
                let modal  = $("#userStatusModal");
                let action = `{{ route('user.staff.status', ':id') }}`;
                let id     = $(this).data(`id`);

                modal.find(`form`).attr('action', action.replace(":id", id));

                modal.find(`.modal-title`).text("@lang('Ban Staff')");
                modal.find(`.ban-message`).removeClass('d-none');
                modal.find(`.ban-reson`).addClass('d-none');
                modal.find('.ban-message').removeClass('d-none');
                $("textarea[name=reason]").attr('required', true);
                modal.modal(`show`);

            });

            $(".unbanBtn").on("click", function(e) {

                let modal  = $("#userStatusModal");
                let action = `{{ route('user.staff.status', ':id') }}`;
                let data   = $(this).data();

                modal.find(`form`).attr('action', action.replace(":id", data.id));

                modal.find(`.modal-title`).text("@lang('Unban Staff')");
                modal.find(`.ban-reason-message`).text(data.banReason);
                modal.find(`.ban-message`).addClass('d-none');
                modal.find(`.ban-reson`).removeClass('d-none');
                modal.find('.ban-message').addClass('d-none');
                $("textarea[name=reason]").attr('required', false);
                modal.modal(`show`);
            })
        })(jQuery);
    </script>
@endpush
