@extends('Template::layouts.frontend')
@section('content')
    @include('Template::partials.breadcrumb')
    <section class="py-110 blog-section " data-background-image="{{ getImage($activeTemplateTrue . 'images/thumbs/beneficial-bg.png') }}">
        <div class="container">
            <div class="row justify-content-center gy-5">
                @include('Template::partials.blog')
            </div>
            @if ($blogs->hasPages())
                <div class="mt-5">
                    {{ paginateLinks($blogs) }}
                </div>
            @endif
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection
