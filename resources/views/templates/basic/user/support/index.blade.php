@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="custom--card card dashboard-table">
                <div class="card-body">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $support)
                                <tr></tr>
                                    <td>
                                        <a  href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold"> [@lang('Ticket')#{{ $support->ticket }}]
                                            {{ __($support->subject) }}
                                        </a>
                                    </td>
                                    <td>
                                        @php echo $support->statusBadge; @endphp
                                    </td>
                                    <td>
                                        @if ($support->priority == Status::PRIORITY_LOW)
                                            <span class="badge badge--dark">@lang('Low')</span>
                                        @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                            <span class="badge  badge--warning">@lang('Medium')</span>
                                        @elseif($support->priority == Status::PRIORITY_HIGH)
                                            <span class="badge badge--danger">@lang('High')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            {{ showDateTime($support->last_reply) }} <br>
                                            {{ diffForHumans($support->last_reply)}}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn-outline--base btn--sm">
                                            <i class="las la-desktop"></i> @lang('Details')
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-message />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ paginateLinks($supports) }}
            </div>
        </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    <a href="{{ route('ticket.open') }}" class="btn btn--sm btn-outline--base"> <i class="las la-plus"></i> @lang('New Ticket')</a>
@endpush
