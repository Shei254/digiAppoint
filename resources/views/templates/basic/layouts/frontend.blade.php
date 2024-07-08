@extends('Template::layouts.app')

@section('panel')
    @include('Template::partials.header')
    <div class="page-wrapper">
        @yield('content')
    </div>
    @include('Template::partials.footer')
@endsection


@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/appoinlab-icons.css') }}">
@endpush
