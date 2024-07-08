@foreach ($blogs as $key => $blogElement)
    <div class="col-lg-4 col-sm-6 col-xsm-6">
        <div class="blog-item">
            <a href="{{ route('blog.details', $blogElement->slug) }}"
                class ="blog-item__thumb">
                <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blogElement->data_values->blog_image, '730x465') }}"
                    alt="image">
            </a>
            <div class="blog-item__content">
                <span class="blog-item__date">
                    <i class="far fa-clock"></i>
                    {{ showDateTime(@$blogElement->created_at, 'd M Y') }}
                </span>
                <h6 class="blog-item__title">
                    <a href="{{ route('blog.details', $blogElement->slug) }}"
                        class="blog-item__link border-effect">{{ __(@$blogElement->data_values->title) }}
                    </a>
                </h6>
                <p class="blog-item__desc mb-4">
                    {{ __(strLimit(strip_tags(@$blogElement->data_values->description), 200)) }}
                </p>
                <a class="mb-4"
                    href="{{ route('blog.details', $blogElement->slug) }}">
                    @lang('Read More')
                </a>
            </div>
        </div>
    </div>
@endforeach
