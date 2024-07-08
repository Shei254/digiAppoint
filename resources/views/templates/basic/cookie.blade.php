@extends('Template::layouts.frontend')
@section('content')
    @include('Template::partials.breadcrumb')
    <section class="recovery-account-wrapper py-110">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @php echo $cookie->data_values->description; @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
