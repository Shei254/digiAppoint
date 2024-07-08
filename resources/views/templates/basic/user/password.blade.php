@extends('Template::layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card custom--card">
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">@lang('Current Password')</label>
                            <input type="password" class="form-control form--control" name="current_password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Password')</label>
                            <input type="password" class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Confirm Password')</label>
                            <input type="password" class="form-control form--control" name="password_confirmation" required
                                autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

