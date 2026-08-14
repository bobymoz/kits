@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="POST" action="{{ route('admin.product.store', @$product->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Photo')</label>
                                    <x-image-uploader class="w-100" type="product" image="{{ @$product->image }}"
                                        :required=false />
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input class="form-control" name="name" type="text"
                                                value="{{ old('name', @$product->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Type')</label>
                                            <select class="form-control select2" name="type"
                                                data-minimum-results-for-search="-1" required>
                                                <option value="2" @selected(@$product->type == 2)>@lang('Free')
                                                </option>
                                                <option value="1" @selected(@$product->type == 1)>@lang('Paid')
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Category')</label>
                                            <select class="form-control select2" name="category_id" required>
                                                <option value="" selected disabled>@lang('Select Oner')</option>
                                                @foreach ($categories as $item)
                                                    <option data-subcategories="{{ $item->subcategories }}"
                                                        value="{{ $item->id }}" @selected($item->id == @$product->category_id)>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Subcategory')</label>
                                            <select class="form-control select2" name="subcategory_id" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Link/File')</label>
                                            <select class="form-control select2" name="file_link"
                                                data-minimum-results-for-search="-1" required>
                                                <option value="1" {{ @$product->link ? 'selected' : '' }}>
                                                    @lang('Link')</option>
                                                <option value="2" {{ @$product->file ? 'selected' : '' }}>
                                                    @lang('File')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 file-upload d-none">
                                        <div class="form-group">
                                            <label>@lang('Upload File') <small class="ml-2">@lang('Accept'): <code
                                                        class="file-extension"></code></small></label>
                                            <input class="form-control" name="file" value="{{ @$product->file }}"
                                                type="file">
                                            @if (@$product->id && @$product->file)
                                                <small>@lang('Existing FIle'): {{ @$product->file }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 file-link">
                                        <label>@lang('Link')</label>
                                        <input name="link" type="url"class="form-control"
                                            value="{{ old('link', @$product->link) }}"
                                            placeholder="@lang('Example') : https://www.demo.com/">
                                    </div>

                                    <div class="col-md-6 paid-price d-none">
                                        <label>@lang('Price')</label>
                                        <div class="input-group">
                                            <input class="form-control" name="price" type="number"
                                                value="{{ old('price', getAmount(@$product->price)) }}" step="any">
                                            <span class="input-group-text"> {{ gs('cur_sym') }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <h5 class="card-header bg--primary d-flex justify-content-between">@lang('Product Information')
                                    <button class="btn btn-sm btn-outline-light addBtn" type="button">
                                        <i class="las la-plus"></i>@lang('Add New')
                                    </button>
                                </h5>

                                <div class="card-body">
                                    <div class="row gy-4 addedProductInfo">
                                        @foreach ($product->information ?? [] as $index => $info)
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 removeProductInfo">
                                                <div class="info-wrapper">
                                                    <div class="form-group">
                                                        <label>@lang('Title')</label>
                                                        <div class="input-group">
                                                            <input class="form-control" value="{{ $info->title }}"
                                                                name="info[{{ $index }}-][title]" type="text"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>@lang('Details')</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="info[{{ $index }}-][detail]" required>{{ $info->detail }}</textarea>
                                                        </div>
                                                    </div>
                                                    <button class="btn removeProductRow btn--danger border--danger"
                                                        type="button"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('Description')</label>
                                            <textarea class="form-control nicEdit" name="description" rows="5">{{ @$product->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit') </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.product.index') }}" />
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";

            @if (old() && old('category_id'))
                $('[name=category_id]').val(@json(old('category_id')));
            @endif

            @if (old() && old('subcategory_id'))
                $('[name=subcategory_id]').val(@json(old('subcategory_id')));
            @endif

            price({{ @$product->type }})

            $('[name="type"]').on('change', function() {
                price($(this).val())
            });

            function price(isPaid) {
                if (isPaid == 1) { //paid
                    $('.paid-price').removeClass('d-none');
                } else {
                    $('.paid-price').addClass('d-none');
                }
            }

            var subcategoryId = `{{ @$product->subcategory_id }}`;



            $('[name="category_id"]').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var subcategories = selectedOption.data('subcategories');
                var subcategorySelect = $('[name="subcategory_id"]');
                subcategorySelect.empty();
                subcategorySelect.append('<option value="" selected disabled>Select One</option>');
                if (subcategories) {
                    $.each(subcategories, function(index, subcategory) {
                        let isSelected = subcategoryId == subcategory.id ? 'selected' : '';
                        subcategorySelect.append(
                            `<option value="${subcategory.id}" ${isSelected}>${subcategory.name}</option>`
                        );
                    });
                }
            }).change();


            getFormats(subcategoryId)

            $('[name="subcategory_id"]').on('change', function() {
                var subcategoryId = $(this).val();
                getFormats(subcategoryId)
            })

            function getFormats(id) {
                $.get(`{{ route('admin.product.formats', '') }}/${id}`, function(response) {
                    if (response.success) {
                        $('.file-extension').text(response.acceptFormats);
                        $('[name="file"]').attr('accept', response.acceptFormats);
                    } else {
                        notify('error', 'Error retrieving formats');
                    }
                });
            }



            // Handle the change event for file_link select
            fileLink({{ @$product->file ? 2 : 1 }})

            $('[name="file_link"]').on('change', function() {
                fileLink($(this).val());
            });

            function fileLink(isFile) {
                if (isFile == 2) { // file
                    $('.file-upload').removeClass('d-none');
                    $('.file-link').addClass('d-none');
                } else {
                    $('.file-upload').addClass('d-none');
                    $('.file-link').removeClass('d-none');
                }
            }


            var count = 0;
            $('.addBtn').on('click', function() {
                $(".addedProductInfo").append(`
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 removeProductInfo">
                    <div class="info-wrapper">
                        <div class="form-group">
                            <label>@lang('Title')<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" name="info[${count}][title]" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Details')<span class="text-danger">*</span></label>
                            <div class="input-group">
                              <textarea class="form-control" name="info[${count}][detail]" required> </textarea>
                            </div>
                        </div>

                        <button class="btn removeProductRow btn--danger border--danger" type="button"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                `)
                count++;
            });

            $(document).on('click', '.removeProductRow', function() {
                $(this).closest('.removeProductInfo').remove();
            });

        });
    </script>
@endpush

@push('style')
    <style>
        .info-wrapper {
            display: flex;
            flex-direction: column;
            padding: 12px;
            border: 1px solid rgb(0 0 0 / 10%);
            border-radius: 8px;
        }
    </style>
@endpush
