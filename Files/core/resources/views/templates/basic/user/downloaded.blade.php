@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="pb-2">
        <h5 class="d-title">{{ __($pageTitle) }}</h5>
        <div class="card custom--card">
            <table class="table cmn--table">
                <thead>
                    <tr>
                        <th>@lang('Date')</th>
                        <th>@lang('Product')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($downloads as $key => $item)
                        <tr>
                            <td>
                                <span>{{ showDateTime($item->created_at, 'Y-m-d') }}</span>
                            </td>
                            <td>
                                <span>{{ strLimit(__($item->product->name), 20) }}
                                    <a href="{{ route('product.details', [slug(__($item->product->name)), $item->product->id]) }}"> <i class="las la-external-link-alt"></i></a>
                                </span>
                            </td>
                            <td>
                                @if ($item->price)
                                    <span class="text--base">{{ showAmount($item->price) }}</span>
                                @else
                                    <span class="text--success">@lang('Free')</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->product->file)
                                    <a class="badge badge--base p-2" data-bs-toggle="tooltip" href="{{ route('user.download.product', Crypt::encrypt($item->product->id)) }}" title="@lang('Download Your Product')"><i class="fas fa-download"></i></a>
                                @elseif ($item->product->link)
                                    <button class="badge badge--info p-2 downloadBtn" data-bs-toggle="tooltip" data-link="{{ $item->product->link }}" type="button" title="@lang('Download Your Product From There!')"><i class="fas fa-download"></i></button>
                                @endif

                                @if (!auth()->user()->existRating($item->product->id))
                                    <button class="badge badge--primary p-2 reviewBtn" data-bs-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#reviewModal" data-id="{{ $item->product->id }}" type="button" title="@lang('Throw Your Review & Rating')"><i class="las la-star"></i></button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">
                                @include($activeTemplate . 'partials.empty', ['message' => 'Download item not found!'])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($downloads->hasPages())
            <div class="pt-3">
                {{ paginateLinks($downloads) }}
            </div>
        @endif
        {{-- Info MODAL --}}
        <div class="modal fade cmn--modal" id="infoModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Download Link')</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="info"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rating --}}
        @if (count($downloads) > 0)
            <div class="modal fade cmn--modal" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('user.download.rating') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="m-0">@lang('Give Review')</h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="mb-2">@lang('Give your rating')</label><br>
                                        <div class='starrr' id='star{{ $key }}'></div><br>
                                        <input id='star2_input' name='rating' type='hidden' value='0'>
                                        <input name="product_id" type="hidden" value="">

                                        <label class="mt-2 mb-2">@lang('Write your opinion')</label><br>
                                        <textarea class="form-control form--control" name="review" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal" type="button">@lang('No')</button>
                                <button class="cmn--btn btn--sm btn--success" type="submit">@lang('Yes')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/starrr.js') }}"></script>
@endpush
@push('style')
    <style>
        .form--control:focus {
            background: #0f1932;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .starrr a {
            font-size: 44px;
            padding: 0 1px;
            cursor: pointer;
            color: #f9a60f;
            text-decoration: none;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            $('.downloadBtn').on('click', function() {
                var modal = $('#infoModal');
                var link = $(this).data('link');

                modal.find('.info').html(`<p><a href="${link}">${link}</a></p>`);
                modal.modal('show');
            });

            $('.reviewBtn').on('click', function() {
                var modal = $('#reviewModal');
                modal.find('input[name=product_id]').val($(this).data('id'));

                var $s2input = $('input[name=rating]');
                var indx = @php echo $downloads->count() @endphp;
                var i = 0;
                for (i; i < indx; i++) {
                    $(`#star${i}`).starrr({
                        max: 5,
                        rating: $s2input.val(),
                        change: function(e, value) {
                            $s2input.val(value).trigger('input');
                        }
                    });
                }
                modal.modal('show');
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

        })(jQuery);
    </script>
@endpush
