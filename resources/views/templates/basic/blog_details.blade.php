@extends('Template::layouts.frontend')
@section('content')
    @include('Template::partials.breadcrumb')
    <section class="blog-detials py-110">
        <div class="container">
            <div class="row gy-5 justify-content-center ">
                <div class="col-xl-9 col-lg-8">
                    <div class="blog-details">
                        <div class="blog-details__thumb">
                            <img src="{{ getImage('assets/images/frontend/blog/' . $blog->data_values->blog_image, '730x465') }}" alt="">
                        </div>
                        <div class="blog-details__content">
                            <span class="blog-item__time mb-2"><span class = "blog-item__date-icon">
                                    <i class = "las la-clock"></i></span>{{ showDateTime(@$blog->created_at, 'd M Y') }}</span>
                            <h3 class = "blog-details__title">{{ __(@$blog->data_values->title) }}</h3>
                            <p class = "blog-details__desc"></p>
                            @php echo $blog->data_values->description @endphp
                        </div>
                        <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                        <div class="mt-4">
                            <h5 class="blog-share__title mt-0 mb-2">@lang('Share')</h5>
                            <ul class="list list--row flex-wrap social-list">
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-list__icon"
                                        target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" class="social-list__icon"
                                        target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}" class="social-list__icon"
                                        target="_blank">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}" class="social-list__icon"
                                        target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Latest Blog')</h5>
                            @foreach ($latestBlogs as $blog)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('blog.details', $blog->slug) }}">
                                            <img src="{{ getImage('assets/images/frontend/blog/' . $blog->data_values->blog_image, '730x465') }}"
                                                alt=""></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title"><a
                                                href="{{ route('blog.details', $blog->slug) }}">{{ __(@$blog->data_values->title) }}</a>
                                        </h6>
                                        <span class="latest-blog__date">{{ @$blog->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush


@push('style')
    <style>
        .blog-share__title {
            position: relative;
            margin-bottom: 10px;
            padding-left: 60px;
            margin-bottom: 25px;
        }

        .blog-share__title::before {
            position: absolute;
            content: "";
            width: 50px;
            height: 3px;
            left: 0;
            top: 50%;
            background-color: hsl(var(--base));
            transform: translateY(-50%);
        }

        .social-list {
            --gap: .5rem;
        }

        .list {
            display: flex;
            flex-direction: column;
            gap: var(--gap, 1rem);
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .list--row {
            flex-direction: row;
        }

        .social-list__icon [class*=facebook] {
            background: #1877f2;
            color: #fff;
        }

        .social-list__icon [class*=pinterest] {
            background: #E60023;
            color: #fff;
        }

        .social-list__icon i,
        .social-list__icon span {
            display: grid;
            place-items: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 18px;
            transition: all 0.3s ease;
            background: hsl(var(--base));
            color: hsl(var(--white));
        }

        .blog-details h6 {
            margin-bottom: 0.5rem !important;
        }
    </style>
@endpush
