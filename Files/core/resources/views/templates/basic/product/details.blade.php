@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <section class="pt-80 pb-80 bg--section">
        <div class="section--wrapper">
            @include($activeTemplate . 'partials.leftbar')

            <div class="container wrapper-inner">
                @php echo getAdvertisement('1188x80') @endphp

                <div class="row gy-5 pt-3">
                    <div class="col-lg-8">
                        <div class="product__details">
                            <div class="product__details-thumb">
                                <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}" alt="product">
                            </div>
                            <div class="product__details-content">
                                <div class="d-flex flex-wrap justify-content-between align-items-center title-area">
                                    <div class="title-side">
                                        <h5 class="product__details-title">{{ __($product->name) }}</h5>
                                        <div class="meta">
                                            <span class="info">@lang('Category') : {{ __($product->category->name) }}</span>
                                            <span class="info">@lang('Subategory') : {{ __($product->subcategory->name) }}</span>
                                            @if ($product->type == 0 && $product->price == null)
                                                <span class="info">@lang('Free')</span>
                                            @endif

                                            @if ($product->type == Status::PRODUCT_PAID && $product->price)
                                                <span class="info">{{ showAmount($product->price) }}</span>
                                            @endif

                                            <span class="info"><i class="las la-download"></i>({{ $product->download }})</span>
                                            <span class="info d-inline-flex">
                                                <span class="ratings">{{ $product->avg_rating }} <i class="las la-star"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="btn-side">
                                        @auth
                                            <a class="cmn--btn btn--sm infoBtn" data-price="{{ $product->price }}" href="javascript:void(0)">@lang('Download')</a>
                                        @else
                                            <a class="cmn--btn btn--sm" href="{{ route('user.login') }}">@lang('Sign in to download')</a>
                                        @endauth
                                    </div>
                                </div>

                                <div class="product-description txt">
                                    @php echo $product->description @endphp
                                </div>

                                <div class="d-flex flex-wrap align-items-center">
                                    <h6 class="share-title my-2 me-4">@lang('Share Now')</h6>
                                    <ul class="social__icons">
                                        <li>
                                            <a href="http://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}&p[title]={{ slug($product->name) }}" title="@lang('Facebook')" target="_blank"><i class="lab la-facebook-f"></i></a>
                                        </li>
                                        <li>
                                            <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ slug($product->name) }}" title="@lang('Twitter')" target="_blank"><i class="lab la-pinterest-p"></i></a>
                                        </li>
                                        <li>
                                            <a href="http://twitter.com/share?text={{ slug($product->name) }}&url={{ urlencode(url()->current()) }}" title="@lang('Twitter')" target="_blank"><i class="lab la-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ slug($product->name) }}" title="@lang('Linkedin')" target="_blank"><i class="lab la-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="nav nav-tabs nav--tabs border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#description">
                                        @lang('Description')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#review">
                                        @lang('Review')
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="description">
                                    <div class="table-wrapper bg--body">
                                        <table class="specification-table">
                                            <tbody>  
                                                <tr>
                                                    <th>@lang('Total Download')</th>
                                                    <th><span class="text--base"><i class="las la-download"></i> ({{ $product->download }})</span></th>
                                                </tr>
                                                @if ($product->information)
                                                    @foreach ($product->information as $info)
                                                        <tr>
                                                            <th>{{ __($info->title) }}</th>
                                                            <th>{{ __($info->detail) }}</th>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="review">
                                    <div class="review-area bg--body">
                                        
                                        @forelse($ratings as $item)
                                            <div class="review-item">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('userProfile') . $item->user->image, getFileSize('userProfile')) }}" alt="owner">
                                                </div>
                                                <div class="content">
                                                    <div class="entry-meta">
                                                        <h6 class="posted-on">
                                                            <a href="javascript:void(0)">{{ __($item->user->fullname) }}</a>
                                                            <span>@lang('Posted on') {{ showDateTime($item->created_at, 'F d, Y') }} @lang('at') {{ showDateTime($item->created_at, 'h:i A') }}</span>
                                                        </h6>
                                                        <div class="ratings">
                                                            @php echo displayRating($item->rating) @endphp
                                                        </div>
                                                    </div>
                                                    <div class="entry-content">
                                                        <p>{{ __($item->review) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="review-item">
                                                <div class="content">
                                                    <div class="entry-meta">
                                                        @include($activeTemplate . 'partials.empty', ['message' => 'Review not found!'])
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>

                                    @if (count($ratings) > 5)
                                        <div class="text-center">
                                            <button class="cmn--btn mt-4" id="loadMoreBtn" type="button">@lang('Load More')</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar__widget">
                            <h5 class="title">@lang('More Products')</h5>
                            <div class="row g-2 g-sm-3">
                                @foreach ($moreProducts as $item)
                                    <div class="col-6 col-md-4 col-lg-12 col-xl-6">
                                        <a class="product__item" href="{{ route('product.details', [slug(__($item->name)), $item->id]) }}">
                                            <img src="{{ getImage(getFilePath('product') . '/thumb_' . $item->image, getFileSize('product')) }}" alt="product">
                                            <span class="download-count">
                                                <i class="las la-download"></i>
                                                <span>({{ $item->download }})</span>
                                            </span>
                                            <div class="product__item-content">
                                                <h6 class="product__item-title">{{ strLimit(__($item->name), 17) }}</h6>
                                                <div class="d-flex justify-content-between">
                                                    <div class="ratings">
                                                        @php echo displayRating($item->avg_rating) @endphp
                                                    </div>
                                                    @if ($item->type == Status::PRODUCT_FREE && $item->price == null)
                                                        <span class="price">@lang('Free')</span>
                                                    @endif

                                                    @if ($item->type == Status::PRODUCT_PAID && $item->price)
                                                        <span class="price"> {{ showAmount($item->price) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @php echo getAdvertisement('3033x375') @endphp
            </div>

            @include($activeTemplate . 'partials.rightbar')
        </div>
    </section>

    {{-- Info MODAL --}}
    <div class="modal fade cmn--modal" id="infoModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('user.download.product.order') }}" method="POST">
                @csrf
                <input name="product_id" type="hidden" value="{{ $product->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Information')</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="info"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('No')</button>
                        <button class="btn btn--base" type="submit">@lang('Yes')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.infoBtn').on('click', function() {
                var modal = $('#infoModal');
                var price = $(this).data('price');
                var message;

                if (price) {
                    message = parseFloat(price).toFixed(2) + " {{ __(gs('cur_text')) }} @lang('will be subtracted from your balance. Are you sure to download this product ?')";
                } else {
                    message = "@lang('Are you sure to download this product ?')";
                }

                modal.find('.info').html(`<p> ${message} </p>`);
                modal.modal('show');
            });


            var counter = 5;

            $('#loadMoreBtn').on('click', function() {
                $.ajax({
                    type: "get",
                    url: "{{ route('load.more.rating') }}",
                    data: {
                        count: counter,
                        id: '{{ $product->id }}'
                    },
                    dataType: "json",
                    success: function(response) {

                        if (response.ratings.length < 5) {
                            $('#loadMoreBtn').remove();
                        }

                        if (response.html) {
                            $('.review-area').append(response.html);
                        }

                        counter = parseInt(counter) + parseInt(5);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
