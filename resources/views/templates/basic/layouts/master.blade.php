<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/appoinlab-icons.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    @stack('style-lib')
    @stack('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs()->base_color }}">
</head>
@php echo loadExtension('google-analytics') @endphp
<body>

    @stack('fbComment')
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>
    <a class="scroll-top"><i class="las la-long-arrow-alt-up"></i></a>

    <div class="dashboard position-relative">
        <div class="dashboard__inner">
            <div class="sidebar-menu flex-between">
                @include('Template::partials.sidebar')
            </div>
            <div class="dashboard__right">
                <div class="dashboard-header">
                    @include('Template::partials.dashboard_header')
                </div>
                <div class="dashboard-body">
                    <div class="d-flex flex-wrap justify-content-between mb-4  gap-2 align-items-center">
                        <h5 class="card-header__title text-dark mb-0">{{ __(@$pageTitle) }}</h5>
                        <div>
                            @stack('breadcrumb-plugins')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    @stack('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    @php echo loadExtension('tawk-chat') @endphp
    @include('partials.notify')
    @if(gs('pn'))
    @include('partials.push_script')
    @endif
    @stack('script')
    <script>
        (function($) {
            "use strict";

            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });
            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });
        })(jQuery);
    </script>
</body>

</html>
