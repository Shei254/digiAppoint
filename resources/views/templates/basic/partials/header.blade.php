<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="image"></a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @php
                        $pages = App\Models\Page::where('tempname', activeTemplate())
                            ->where('is_default', Status::NO)
                            ->get();
                    @endphp
                    @foreach ($pages as $k => $data)
                        <li class="nav-item">
                            <a href="{{ route('pages', [$data->slug]) }}" class="nav-link">{{ __($data->name) }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pricing') }}">@lang('Pricing')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>

                    <li class="nav-item header-access-button">
                        @guest
                            <a class="btn btn--base rounded account-btn d-none d-lg-block" href="{{ route('user.login') }}"><i class="icon-user"></i></a>
                            <a href="{{ route('user.register') }}" class="btn btn--base">@lang('Get Started')</a>
                        @else
                            <a href="{{ route('user.home') }}" class="btn btn--base">@lang('Dashboard')</a>
                        @endguest
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
