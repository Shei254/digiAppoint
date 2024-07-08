@extends('Template::layouts.master')
@section('content')
    <div class="custom--card card">
        <div class="card-body">
            <form action="{{ route('user.staff.store') }}" method="POST" class="account__form">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('First Name')</label>
                        <input type="text" class="form-control form--control" name="firstname" value="{{ old('firstname') }}" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('Last Name')</label>
                        <input type="text" class="form-control form--control" name="lastname" value="{{ old('lastname') }}" required>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form--label">@lang('Username')</label>
                            <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                            <small class="text-danger usernameExist"></small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form--label">@lang('Email Address')</label>
                            <input type="email" class="form-control form--control checkUser" name="email" value="{{ old('email') }}" required>
                            <small class="text-danger emailExist"></small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form--label">@lang('Country')</label>
                            <select name="country" class="select form--control">
                                @foreach ($countries as $key => $country)
                                    <option data-dial_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                        {{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form--label">@lang('Phone Number')</label>
                            <div class="input-group ">
                                <span class="input-group-text mobile-code">
                                </span>
                                <input type="hidden" name="dial_code">
                                <input type="hidden" name="country_code">
                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                                <small class="text-danger mobileExist"></small>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('Address')</label>
                        <input type="text" class="form-control form--control" name="address" value="{{ old('address') }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('State')</label>
                        <input type="text" class="form-control form--control" name="state" value="{{ old('state') }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('Zip Code')</label>
                        <input type="text" class="form-control form--control" name="zip" value="{{ old('zip') }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('City')</label>
                        <input type="text" class="form-control form--control" name="city" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                        <label class="form--label">@lang('Password')</label>
                        <div class="input-group position-relative">
                            <span class="input-group-text generate-password"   title="@lang("Generate Password")"><i class="las la-magic"></i></span>
                            <input id="your-password" type="password" class="form-control form--control" name="password" required>
                            <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#your-password">
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Create')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-outline--base btn--sm" href="{{ route('user.staff.list') }}">
        <i class="las la-list"></i> @lang('Staff List')
    </a>
@endpush

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('style')
    <style>
        .input-group-text {
            color: #ffffff;
            background-color: hsl(var(--base)) !important;
            border: 1px solid #ced4da;
        }
        .generate-password {
           cursor: pointer;
        }
    </style>
@endpush
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on("change",function() {
                $('input[name=dial_code]').val($('select[name=country] :selected').data('dial_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('dial_code'));
            });
            $('input[name=dial_code]').val($('select[name=country] :selected').data('dial_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('dial_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.staff.check') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });

            $(".generate-password").on('click', function(e) {
                var passwordField     = document.getElementById('your-password');
                var generatedPassword = generateRandomPassword();

                passwordField.value = generatedPassword;
            });

            function generateRandomPassword() {
                var passwordLength = Math.floor(Math.random() * (10 - 6 + 1)) + 6;
                var charset        = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}|:<>?-=[];',./";
                var password       = "";

                for (var i = 0; i < passwordLength; i++) {
                    var randomCharIndex = Math.floor(Math.random() * charset.length);
                    password += charset[randomCharIndex];
                }

                return password;
            }
        })(jQuery);

    </script>
@endpush
