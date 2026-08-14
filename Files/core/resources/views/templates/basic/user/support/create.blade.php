@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
        <h5 class="d-title m-0">{{ __($pageTitle) }}</h5>
        <a class="btn cmn--btn" href="{{ route('ticket.index') }}">@lang('Ticket History')</a>
    </div>
    <div class="card custom--card mb-3">

        <div class="card-body">
            <form class="disableSubmission" action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Subject')</label>
                        <input class="form-control form--control" name="subject" type="text" value="{{ old('subject') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Priority')</label>
                        <select class="form-control form--control select2" name="priority" data-minimum-results-for-search="-1" required>
                            <option value="3">@lang('High')</option>
                            <option value="2">@lang('Medium')</option>
                            <option value="1">@lang('Low')</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="form-label">@lang('Message')</label>
                        <textarea class="form-control form--control" id="inputMessage" name="message" rows="6" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="col-md-9">
                        <button class="btn btn--dark addAttachment my-2" type="button"> <i class="fas fa-plus"></i> @lang('Add Attachment') </button>
                        <p class="my-3"><span class="text--info">@lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span></p>
                        <div class="row fileUploadsContainer">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn cmn--btn w-100 justify-content-center my-2" type="submit"><i class="las la-paper-plane"></i> @lang('Submit')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .light-version .bg--section .form--control {
            background-color: #fff !important;
        }
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2').select2();
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-4 col-md-12 removeFileInput pt-3">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control form--control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <button type="button" class="input-group-text removeFile bg--danger border--danger"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush
