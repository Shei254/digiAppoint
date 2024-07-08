@extends('Template::layouts.app')
@section('panel')
    @php
        $loginContent = @getContent('login.content', true)->data_values;
    @endphp
    <section class="account">
        <div class="account__inner">
            <div class="account__left">
                <div class="account__thumb">
                    <img src="{{ getImage("assets/images/frontend/login/".@$loginContent->image) }}" alt="image">
                </div>                            
            </div>
            <div class="account__right">
                <div class="account__content login">
                    <div class="account__content-header mb-5 d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="image"></a>
                        <div class="account-content__member flex-align">
                            <p class="account-content__member-text"> @if (gs('registration')) @lang('Do not have an account')? @endif</p>
                            <a class="ms-1" href="{{ route('user.register')}}" class="text--base"> @if (gs('registration'))@lang('Sign Up') @endif  </a>
                        </div>
                    </div>
                    <div class="account-heading mb-5">
                        <h4 class="mb-2">
                            {{ __(@$loginContent->heading)}}
                        </h4>
                        <p>{{ __(@$loginContent->subheading)}}</p>
                    </div>  
                    <form action="{{ route('user.login') }}" method="POST" class="verify-gcaptcha account__form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="username" class="form--label required">@lang('Username or Email')</label>
                                    <input type="text" class="form--control" id="username" name="username" value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password" class="form--label required">@lang('Password')</label>
                                    <div class="position-relative">
                                        <input id="password" type="password" name="password" class="form-control form--control" required>
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
                                    </div>
                                </div>
                            </div>
                            <x-captcha />
                            <div class="col-12">
                                <div class="form-group remember-forgot">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                    </div>
                                    <a href="{{ route('user.password.request') }}" class="forgot-password">@lang('Forgot your password?')</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn--base w-100">@lang('Sign In')</button>
                            </div>

                            @include('Template::partials.social_login')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================= Account End ============================ -->
@endsection
