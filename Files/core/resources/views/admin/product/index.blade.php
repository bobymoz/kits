@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Categogry')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('File Or Link')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Download')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($products as $item)
                                    <tr>
                                        <td>{{ $products->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="user justify-content-center">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('product') . '/thumb_' . $item->image, getFileSize('product')) }}" alt="">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ __($item->name) }}</td>
                                        <td>{{ __($item->category->name) }}</td>
                                        <td>
                                            @php echo $item->typeBadge;  @endphp
                                        </td>
                                        <td>
                                            @if ($item->file)
                                                <span class="badge badge--success">@lang('File')</span>
                                            @elseif ($item->link)
                                                <span class="badge badge--primary">@lang('Link')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->type == Status::PRODUCT_PAID && $item->price > 0)
                                                <span class="fw-bold">{{ showAmount($item->price) }}</span>
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td>{{ $item->download }}</td>
                                        <td>
                                            @php echo $item->statusbadge; @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.product.page.seo',$item->id) }}" class="btn btn-sm btn-outline--info"><i class="la la-cog"></i> @lang('SEO Setting')</a>

                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.product.edit', $item->id) }}">
                                                    <i class="las la-pencil-alt"></i> @lang('Edit')
                                                </a>
                                                @if ($item->status == Status::DISABLE)
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{ route('admin.product.status', $item->id) }}" data-question="@lang('Are you sure to enable this product?')" type="button">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.product.status', $item->id) }}" data-question="@lang('Are you sure to disable this product?')" type="button">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($products->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($products) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Product | category" />
    <a class="btn btn-outline--primary" href="{{ route('admin.product.add') }}"><i class="fas la-plus"></i>@lang('Add New')</a>
@endpush
