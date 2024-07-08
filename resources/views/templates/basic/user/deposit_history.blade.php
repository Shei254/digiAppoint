@extends('Template::layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="custom--card card dashboard-table">
                <div class="card-body">
                    <table class="table table--responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Pricing Plan')</th>
                                <th>@lang('Gateway | Transaction')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Purchased at')</th>
                                <th>@lang('Expire on')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td>
                                        <div>
                                            {{ __(@$deposit->pricing->name) }} <br>
                                            @if ($deposit->pricing_type == 'monthly')
                                                <small>@lang('Monthly')</small>
                                            @else
                                                <small>@lang('Yearly')</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold"> <span class="text-primary">{{ __($deposit->gateway?->name) }}</span> </span>
                                            <br>
                                            <small> {{ $deposit->trx }} </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>

                                            {{ showAmount($deposit->amount) }} + <span class="text-danger"
                                                title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }}
                                            </strong>
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            {{ showDateTime($deposit->created_at, format: 'Y-m-d') }}<br>{{ diffForHumans($deposit->created_at) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ showDateTime($deposit->user->expire_on, format: 'Y-m-d') }}<br>{{ diffForHumans($deposit->user->expire_on) }}
                                        </div>
                                    </td>
                                    <td>
                                        @php echo $deposit->statusBadge @endphp
                                    </td>
                                </tr>
                            @empty
                                <x-empty-message />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($deposits->hasPages())
                    <div class="card-footer">
                        {{ $deposits->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <form>
        <div class="input-group">
            <input type="text" name="search" class="form--control form-control" value="{{ request()->search }}" placeholder="@lang('Search')">
            <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush
