@extends('Template::layouts.frontend')
@section('content')
    @php
        $contactContent = getContent('contact_us.content', true);
        $contactElements = getContent('contact_us.element', orderById: true);
    @endphp
    @include('Template::partials.breadcrumb')
    <section class="contact-section py-110">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-wrapper">
                        <div class="contact-info">
                            <span class="contact-info__shape">
                                <img src="{{ getImage($activeTemplateTrue . 'images/shapes/contact-info-shape.png') }}" alt="Shape">
                            </span>
                            <h3 class="contact-info__title">{{ __(@$contactContent->data_values->title) }}</h3>
                            <p class="contact-info__desc">
                                {{ __(@$contactContent->data_values->short_details) }}
                            </p>
                            <ul class="contact-info__list">
                                <li class="contact-info__item">
                                    <span class="icon"><i class="las la-phone-volume"></i></span>
                                    <div class="content">
                                        <span class="text">{{ $contactContent->data_values->contact_number }}</span>
                                    </div>
                                </li>
                                <li class="contact-info__item">
                                    <span class="icon"><i class="las la-envelope"></i></span>
                                    <div class="content">
                                        <span class="text">{{ $contactContent->data_values->email_address }}</span>
                                    </div>
                                </li>
                                <li class="contact-info__item">
                                    <span class="icon"><i class="las la-map-marker-alt"></i></span>
                                    <div class="content">
                                        <span class="text">{{ __(@$contactContent->data_values->location) }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <form action="{{ route('contactSubmit') }}" method="post" class="contact-form verify-gcaptcha">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label  class="form--label">@lang('Name')</label>
                                        <input type="text" name="name" class="form--control" value="{{ old('name', @$user->fullname) }}"
                                            @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label  class="form--label">@lang('Email')</label>
                                        <input type="email" name="email" class="form--control" value="{{ old('email', @$user->email) }}"
                                            @if ($user) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label  class="form--label">@lang('Subject')</label>
                                        <input type="text" name="subject" class="form--control" value="{{ old('subject') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form--label">@lang('Message')</label>
                                        <textarea name="message" id="message" class="form-control form--control" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <x-captcha />
                                <div class="col-12">
                                    <div class="form-group mb-0 text-end">
                                        <button type="submit" class="btn btn--base">@lang('Send Message')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="contact-map">
                        <iframe src="{{ @$contactContent->data_values->map_url }}">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection
