@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-80 pb-80 bg--section">
        <div class="section--wrapper">
            @include($activeTemplate . 'partials.leftbar')

            <div class="container wrapper-inner">
                <div class="filter-category-header">
                    <div class="fileter-select-item me-auto show-results">
                        <div>@lang('Showing') <span class="text--base">{{ $products->count() }} @lang('of') {{ $products->total() }}</span></div>
                    </div>
                </div>
                <div class="row g-2 g-sm-3 mb-5">
                    @forelse ($products as $item)
                        @include($activeTemplate . 'partials.product')
                    @empty
                        <div class="col-xl-12 col-md-12 col-12 p-custom-width">
                            @include($activeTemplate . 'partials.empty', ['message' => 'Product not found!'])
                        </div>
                    @endforelse

                    {{ paginateLinks($products) }}

                </div>

                @php echo getAdvertisement('1188x80') @endphp
            </div>

            @include($activeTemplate . 'partials.rightbar')
        </div>
    </section>
@endsection
