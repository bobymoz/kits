<!-- Header -->
<header class="front-header">
    <div class="header-top">
        <div class="container">
            <ul class="header-top-wrapper">
                <li class="me-auto">
                    @include($activeTemplate . 'partials.language')
                </li>
                @auth
                    <li>
                        <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                    </li>
                    <li>
                        <a class="header-btn" href="{{ route('user.logout') }}">@lang('Logout')</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('user.register') }}">@lang('Sign Up')</a>
                    </li>
                    <li>
                        <a class="header-btn" href="{{ route('user.login') }}">@lang('Sign In')</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo-mode">
                    <a href="{{ route('home') }}">
                        <img alt="logo" src="{{ siteLogo() }}">
                    </a>
                </div>
                <form class="search-form" method="GET" action="{{ route('products') }}">
                    <div class="input-group">
                        <input class="form-control" value="{{ request()->search }}" name="search" type="text" placeholder="@lang('Explore Creative Products & Categories...')">
                        <button class="cmn--btn input-group-text" type="submit"><i class="las la-search"></i></button>
                    </div>
                </form>
                <ul class="menu">
                    @foreach ($categories as $key => $item)
                        @if ($key < 6)
                            <li>
                                <a href="javascript:void(0)">{{ __($item->name) }}</a>
                                @if (count($item->subcategories) > 0)
                                    <ul class="submenu">
                                        @foreach ($item->subcategories as $item)
                                            <li>
                                                <a href="{{ route('products') }}?search={{ strtolower($item->name) }}">{{ __($item->name) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @else
                            <li>
                                <a href="javascript:void(0)">@lang('More')</a>
                                <ul class="mega__menu">
                                    <li>
                                        <ul class="d-flex flex-wrap mega-menu-wrapper">
                                            <li class="mega__menu-item">
                                                <h6 class="title">{{ __($item->name) }}</h6>
                                                @if (count($item->subcategories) > 0)
                                                    <ul>
                                                        @foreach ($item->subcategories as $data)
                                                            <li>
                                                                <a href="{{ route('subcategory.search', [slug($data->name), $data->id]) }}">{{ __($data->name) }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif

                    @endforeach
                </ul>
                <div class="search-bar d-md-none ms-auto">
                    <i class="las la-search"></i>
                </div>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header -->
