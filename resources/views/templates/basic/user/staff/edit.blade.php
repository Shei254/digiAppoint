@extends('Template::layouts.master')
@section('content')
    <div class="dashboard-bottom">
        <div class="custom--card card dashboard-table">
            <div class="card-body">
                <form class="register" action="{{ route('user.staff.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="form--label">@lang('First Name')</label>
                            <input type="text" class="form-control form--control" name="firstname" value="{{$user->firstname}}" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="form--label">@lang('Last Name')</label>
                            <input type="text" class="form-control form--control" name="lastname" value="{{$user->lastname}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="form--label">@lang('E-mail Address')</label>
                            <input class="form-control form--control" value="{{$user->email}}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="form--label">@lang('Mobile Number')</label>
                            <input class="form-control form--control" value="{{$user->mobile}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="form--label">@lang('Address')</label>
                            <input type="text" class="form-control form--control" name="address" value="{{@$user->address}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="form--label">@lang('State')</label>
                            <input type="text" class="form-control form--control" name="state" value="{{@$user->state}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="form--label">@lang('Zip Code')</label>
                            <input type="text" class="form-control form--control" name="zip" value="{{@$user->zip}}">
                        </div>

                        <div class="form-group col-sm-4">
                            <label class="form--label">@lang('City')</label>
                            <input type="text" class="form-control form--control" name="city" value="{{@$user->city}}">
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="form--label">@lang('Country')</label>
                            <input class="form-control form--control" value="{{@$user->country_name}}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-outline--base btn--sm" href="{{ route('user.staff.list') }}">
        <i class="las la-list"></i> @lang('Staff List')
    </a>
@endpush