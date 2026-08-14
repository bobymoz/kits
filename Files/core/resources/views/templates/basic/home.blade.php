@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-80 pb-80 bg--section">
        <div class="section--wrapper">
            @include($activeTemplate . 'partials.leftbar')

            <div class="wrapper-inner container">
                @php echo getAdvertisement('1188x80') @endphp

                <div class="section__header d-flex justify-content-between mt-2">
                    <h4 class="section__title text--base">@lang('Our Products')</h4>
                    <ul class="header-links">
                        <li>
                            <a class="btn cmn--btn" href="{{ route('products') }}"> → @lang('View All')</a>
                        </li>
                    </ul>
                </div>

                <div class="row g-2 g-sm-3">
                    @forelse ($products as $item)
                        @include($activeTemplate . 'partials.product')

                    @empty
                        @include($activeTemplate . 'partials.empty', ['message' => 'Product not found!'])
                    @endforelse
                </div>

                @php echo getAdvertisement('3033x375') @endphp
            </div>

            @include($activeTemplate . 'partials.rightbar')
        </div>
    </section>

    <section class="pt-80 pb-80">
        <div class="section--wrapper">
            @include($activeTemplate . 'partials.leftbar')

            <div class="wrapper-inner container">
                @php echo getAdvertisement('1188x80') @endphp

                <div class="section__header mt-2">
                    <h4 class="section__title text--base">@lang('Top Rated')</h4>
                </div>
                <div class="row g-2 g-sm-3">
                    @foreach (@$topRatedProducts as $item)
                        @include($activeTemplate . 'partials.product')
                    @endforeach
                </div>

                @php echo getAdvertisement('3033x375') @endphp

            </div>

            @include($activeTemplate . 'partials.rightbar')
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
    
@endsection
