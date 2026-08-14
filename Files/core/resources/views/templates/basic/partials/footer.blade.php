@php
    $subscribeContent = getContent('subscribe.content', true);
    $socialIconElements = getContent('social_icon.element', orderById: true);
    $footerContent = getContent('footer.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp
<!-- Foo

<!-- Footer Section -->
<footer class="front-footer">
    <div class="newsletter-section">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="newsletter-title">
                    <div class="section__header border-0">
                        <h4 class="section__title mb-0">@lang('Newsletter') <span
                                  class="text--base">@lang('Subscription')</span></h4>
                        <p>{{ __(@$subscribeContent->data_values->content) }}</p>
                    </div>
                </div>
                <div class="newsletter-form">
                    <form class="search-form subscribe-form" method="POST" action="{{ route('subscribe') }}">
                        <div class="input-group">
                            <input class="form-control" name="email" type="email" placeholder="@lang('Enter Your Email')"
                                   required>
                            <button class="input-group-text cmn--btn" type="submit"><i
                                   class="las la-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footter-top @if (request()->routeIs('home')) bg--section @endif">

        <div class="container">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-4">
                    <div class="footer__widget footer__widget-about">
                        <div class="logo-mode logo">
                            <a href="{{ route('home') }}">
                                <img alt="logo">
                            </a>
                        </div>
                        <p class="addr">
                            {{ __(@$footerContent->data_values->content) }}
                        </p>
                        <ul class="social__icons">
                            @foreach (@$socialIconElements as $icon)
                                <li>
                                    <a href="{{ @$icon->data_values->url }}"
                                       title="{{ __(@$icon->data_values->title) }}" target="_blank">
                                        @php
                                            echo @$icon->data_values->social_icon;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4 gy-5 pl-xl-5">
                        <div class="col-sm-4 col-6">
                            <div class="footer__widget">
                                <h5 class="widget--title">@lang('Shortcut Link')</h5>
                                <ul class="footer__links">
                                    @foreach (@$pages as $k => $data)
                                        <li>
                                            <a href="{{ route('pages', [@$data->slug]) }}">{{ __(@$data->name) }}</a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="{{ route('products') }}">@lang('Products')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('blogs') }}">@lang('Blog')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}">@lang('Contact')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="footer__widget">
                                <h5 class="widget--title">@lang('Company Policy')</h5>
                                <ul class="footer__links">
                                    @foreach ($policyPages as $policy)
                                        <li>
                                            <a href="{{ route('policy.pages', $policy->slug) }}">
                                                {{ __(@$policy->data_values->title) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="footer__widget">
                                <h5 class="widget--title">@lang('Categories')</h5>
                                <ul class="footer__links">
                                    @foreach ($categories->take(4) as $item)
                                        <li>
                                            <a
                                               href="{{ route('products') }}?search={{ strtolower($item->name) }}">{{ __($item->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom @if (request()->routeIs('home')) bg--body @else bg--section @endif  text-center">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="left">
                    @lang('Copyright') &copy; @php echo date('Y') @endphp {{ __(gs('site_name')) }} @lang('All Rights Reserved')
                </div>
                <div class="right">
                    <img src="{{ frontendImage('footer', @$footerContent->data_values->payment_image, '250x30') }}" alt="footer">
                </div>
            </div>
        </div>
    </div>
</footer>

@push('script')
    <script>
        'use strict';

        $(function() {
            $('.subscribe-form').on('submit', function(event) {
                event.preventDefault();
                var email = $('.subscribe-form').find('[name="email"]').val();
                if (!email) {
                    notify('error', 'Email field is required');
                } else {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('subscribe') }}",
                        method: "POST",
                        data: {
                            email: email
                        },
                        success: function(response) {
                            if (response.success) {
                                notify('success', response.message);
                            } else {
                                notify('error', response.error);
                            }
                            $('.subscribe-form').find('[name="email"]').val('');
                        }
                    });
                }
            });

        })
    </script>
@endpush
