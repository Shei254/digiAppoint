@extends('Template::layouts.frontend')

@section('content')

    <section class="py-110">
        <div class="container">
            @if ($sections != null)
                @foreach (json_decode($sections) as $sec)
                    @include('Template::sections.' . $sec)
                @endforeach
            @endif
        </div>
    </section>

@endsection
