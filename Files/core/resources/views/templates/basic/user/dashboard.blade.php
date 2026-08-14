@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="notice pb-3"></div>

    <div class="row justify-content-center g-4">
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="far fa-money-bill-alt"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ gs('cur_sym').showAmount($user->balance, currencyFormat:false) }} </h2>
                    </div>
                    <a href="#0">@lang('Balance')</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="fas fa-download"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ $totalDownloads }}</h2>
                    </div>
                    <a href="#0">@lang('Downloads')</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="dashboard-item">
                <span class="dashboard-icon">
                    <i class="fas fa-comments-dollar"></i>
                </span>
                <div class="cont">
                    <div class="dashboard-header">
                        <h2 class="title">{{ $totalTransactions }}</h2>
                    </div>
                    <a href="#0">@lang('Transaction')</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Table -->
    <div class="pt-80">
        <h5 class="d-title">@lang('Latest Download')</h5>
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
                @forelse ($latestDownloads as $key => $item)
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
                                <span class="text--info">@lang('Free')</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->product->file)
                                <a class="badge badge--primary px-2 py-2" href="{{ route('user.download.product', Crypt::encrypt($item->product->id)) }}"><i class="fas fa-download"></i></a>
                            @elseif ($item->product->link)
                                <a class="badge badge--primary px-2 py-2 downloadBtn" data-link="{{ $item->product->link }}" href="javascript:void(0)"><i class="fas fa-download"></i></a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Info MODAL --}}
    <div class="modal fade cmn--modal" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Download Link')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="info"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.downloadBtn').on('click', function() {
                var modal = $('#infoModal');
                var link = $(this).data('link');

                modal.find('.info').html(`<p><a href="${link}">${link}</a></p>`);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush

