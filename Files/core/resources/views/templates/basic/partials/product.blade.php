<div class="col-xl-3 col-md-4 col-6 p-custom-width">
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
                @if ($item->type == Status::PRODUCT_FREE && $item->price == 0)
                    <span class="price">@lang('Free')</span>
                @endif

                @if ($item->type == Status::PRODUCT_PAID && $item->price)
                    <span class="price">{{ showAmount($item->price) }}</span>
                @endif
            </div>
        </div>
    </a>
</div>
