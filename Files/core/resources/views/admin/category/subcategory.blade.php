@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('File Formats')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $subcategories->firstItem() + $loop->index }}</td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>{{ $subcategory->formats_count }}</td>
                                        <td>@php echo $subcategory->statusBadge; @endphp</td>
                                        <td>

                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--info" href="{{ route('admin.category.subcategory.file.format', $subcategory->id) }}">
                                                    <i class="la la-file-alt"></i>@lang('File Format')
                                                </a>
                                                <button class="btn btn-sm btn-outline--primary editBtn cuModalBtn" data-resource="{{ $subcategory }}" data-modal_title="@lang('Edit Subcategory')" data-has_status="1" type="button">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>
                                                @if ($subcategory->status == Status::DISABLE)
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{ route('admin.category.subcategory.status', $subcategory->id) }}" data-question="@lang('Are you sure to enable this subcategory?')" type="button">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.category.subcategory.status', $subcategory->id) }}" data-question="@lang('Are you sure to disable this subcategory?')" type="button">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($subcategories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subcategories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="cuModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button"><i class="las la-times"></i></button>
                </div>
                <form method="post" action="{{ route('admin.category.subcategory.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" name="category_id" type="hidden" value="{{ $category->id }}" required>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search by name" />
    <button class="btn btn-outline--primary cuModalBtn" data-modal_title="@lang('Add Subcategory')" type="button"><i class="las la-plus"></i> @lang('Add New')</button>
    <x-back route="{{ route('admin.category.index') }}" />
@endpush
