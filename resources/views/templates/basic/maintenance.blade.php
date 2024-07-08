@extends('Template::layouts.frontend')
@section('content')
    <section class="recovery-account-wrapper py-110">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="text-center">
                        <img class="img-fluid mx-auto mb-5" src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}" alt="image">
                        @php echo $maintenance->data_values->description @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
<style>

body{
    justify-content: center;
    align-items: center;
}
header,footer, .breadcrumb{
    display: none;
}
</style>
@endpush
