@php
    $blogContent  = @getContent('blog.content', true)->data_values;
    $blogElements = getContent('blog.element', orderById: true);
@endphp
<section class="pb-110" data-background-image="{{ getImage($activeTemplateTrue . 'images/thumbs/beneficial-bg.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title" data-s-break="1">{{ __(@$blogContent->heading)}}</h2>
                    <p>{{ __(@$blogContent->subheading)}}</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center gy-5">
            @include('Template::partials.blog',['blogs' => $blogElements])
        </div>
    </div>
</section>
