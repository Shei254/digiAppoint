@php
    $footerInfoContent = getContent('footer_info.content', true);
    $contactUsContent = getContent('contact_us.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
    $socialElements = getContent('social_icon.element', false, orderById: true);
@endphp

<footer class="footer-area">
    <span class="footer-area__shape"><img src="{{ getImage($activeTemplateTrue . 'images/shapes/5.png') }}"
            alt="image"></span>
    <span class="footer-area__shape two"><img src="{{ getImage($activeTemplateTrue . 'images/shapes/6.png') }}"
            alt="image"></span>
    <div class="footer-area__inner pt-110">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-5 col-lg-3 col-md-12">
                    <div class="footer-item">
                        <a href="{{ route('home') }}">
                            <img src="{{ siteLogo('dark') }}" alt="" class="mb-3">
                        </a>
                        <p class="footer-item__desc">{{ __(@$footerInfoContent->data_values->short_details) }}</p>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Quick Links')</h6>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a href="{{ route('home') }}" class="footer-menu__link">@lang('Home')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('contact') }}" class="footer-menu__link">@lang('Contact')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('blog') }}" class="footer-menu__link">@lang('Blog')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Policy Links')</h6>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item">
                                    <a class="footer-menu__link"
                                        href="{{ route('policy.pages', $policy->slug) }}">
                                        {{ __($policy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Contact Info')</h6>
                        <ul class="footer-contact-menu">
                            <li class="footer-contact-menu__item">
                                {{ __(@$contactUsContent->data_values->location) }}
                            </li>
                            <li class="footer-contact-menu__item">
                                <a
                                    href="tel:{{ str_replace(' ', '', @$contactUsContent->data_values->contact_number) }}">
                                    {{ @$contactUsContent->data_values->contact_number }}
                                </a>
                            </li>
                            <li class="footer-contact-menu__item">
                                <a class="" href="mailto:{{ @$contactUsContent->data_values->email_address }}">
                                    {{ @$contactUsContent->data_values->email_address }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer py-3">
        <div class="container">
            <div class="d-flex justify-content-center flex-wrap gap-2 justify-content-md-between">
                <p class="bottom-footer__text">
                    ©{{ date('Y') }} <a href="{{ route('home') }}">{{ __(gs()->site_name) }}.</a>
                    @lang('All Right Reserved').
                </p>
                <ul class="social-list justify-content-center mb-2">
                    @foreach ($socialElements as $socialElement)
                        <li class="social-list__item">
                            <a href="{{ @$socialElement->data_values->url }}"
                                class="social-list__link {{ strtolower(@$socialElement->data_values->title) }}"
                                target="_blank">
                                @php echo @$socialElement->data_values->social_icon @endphp
                            </a>
                        </li>
                    @endforeach

                    @if (gs()->multi_language)
                        @php
                            $language = App\Models\Language::all();
                            $selectLang = $language->where('code', config('app.locale'))->first();
                        @endphp

                        <li class="language dropdown">
                            <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="language-content">
                                    <div class="language_flag">
                                        <img src="{{ getImage(getFilePath('language') . '/' . $selectLang->image, getFileSize('language')) }}"
                                            alt="flag">
                                    </div>
                                    <p class="language_text_select">{{ __(@$selectLang->name) }}</p>
                                </div>
                                <span class="collapse-icon"><i class="las la-angle-down"></i></span>
                            </button>

                            <div class="dropdown-menu langList_dropdow py-2" style="">
                                <ul class="langList">
                                    @foreach ($language as $item)
                                        <li class="language-list">
                                            <a href="{{ route('lang', $item->code) }}">
                                                <div class="language_flag">
                                                    <img src="{{ getImage(getFilePath('language') . '/' . $item->image, getFileSize('language')) }}"
                                                        alt="flag">
                                                </div>

                                            </a>
                                            <a href="{{ route('lang', $item->code) }}">
                                                <p
                                                    class="language_text @if (session('lang') == $item->code) custom--dropdown__selected @endif">
                                                    {{ __($item->name) }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</footer>
@push('script')
    <script>
        $(document).ready(function() {
            const $mainlangList = $(".langList");
            const $langBtn = $(".language-content");
            const $langListItem = $mainlangList.children();
            $langListItem.each(function() {
                const $innerItem = $(this);
                const $languageText = $innerItem.find(".language_text");
                const $languageFlag = $innerItem.find(".language_flag");
                $innerItem.on("click", function(e) {
                    $langBtn.find(".language_text_select").text($languageText.text());
                    $langBtn.find(".language_flag").html($languageFlag.html());
                });
            });
        });
    </script>
@endpush
@push('style')
    <style>
        .language-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 5px 12px;
            border-radius: 4px;
            width: 130px;
            background-color: rgb(255 255 255 / 3%);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            height: 38px;
        }

        .language_flag {
            flex-shrink: 0
        }

        .language_flag img {
            height: 20px;
            width: 20px;
            object-fit: cover;
            border-radius: 50%;
        }

        .language-wrapper.show .collapse-icon {
            transform: rotate(180deg)
        }

        .collapse-icon {
            font-size: 14px;
            display: flex;
            transition: all linear 0.2s;
            color: hsl(var(--white))
        }

        .language_text_select {
            font-size: 14px;
            font-weight: 400;
            color: hsl(var(--white))
        }

        .language-content {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .language_text {
            color: #FFFFFF
        }

        .language-list {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .language .dropdown-menu {
            position: absolute;
            -webkit-transition: ease-in-out 0.1s;
            transition: ease-in-out 0.1s;
            opacity: 0;
            visibility: hidden;
            bottom: 100%;
            display: unset;
            background: #2A313B;
            -webkit-transform: scaleY(1);
            transform: scaleY(1);
            min-width: 150px;
            padding: 7px 0 !important;
            border-radius: 8px;
            border: 1px solid rgb(255 255 255 / 10%);
        }

        .language .dropdown-menu.show {
            visibility: visible;
            opacity: 1;
            inset: unset !important;
            margin: 0px !important;
            transform: unset !important;
            bottom: 100% !important;
        }
    </style>
@endpush
