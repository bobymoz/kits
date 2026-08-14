@extends($activeTemplate . 'layouts.master')
@section('content')
    <form class="profile-area bg--body" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="user-profile">
                    <div class="thumb">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}" alt="user">
                    </div>
                    <div class="content">
                        <h5 class="title">{{ $user->fullname }}</h5>
                        <span>@lang('Username'): {{ $user->username }}</span>
                    </div>
                    <div class="mt-3">
                        <div class="remove-image cmn--btn btn--sm btn--danger w-100 justify-content-center text-center mb-3">
                            <i class="las la-times"></i> @lang('Remove')
                        </div>
                        <label class="show-image cmn--btn btn--base w-100 justify-content-center text-center" for="profile-image">@lang('Change Profile Photo')</label>
                        <input class="form-control form--control" id="profile-image" name="image" type="file" accept="image/*" hidden>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="user-profile-form row mb--20">
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('First Name')</label>
                        <input type="text" class="form-control form--control" name="firstname" value="{{ $user->firstname }}" required>
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('Last Name')</label>
                        <input type="text" class="form-control form--control" name="lastname" value="{{ $user->lastname }}" required>
                    </div>
                    <div class="col-md-12 mb-20">
                        <label class="form--label">@lang('Email Address')</label>
                        <input class="form-control form--control" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('Mobile Number')</label>
                        <input class="form-control form--control" value="{{ $user->mobile }}" readonly>
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('Address')</label>
                        <input type="text" class="form-control form--control" name="address" value="{{ @$user->address }}">
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('State')</label>
                        <input type="text" class="form-control form--control" name="state" value="{{ @$user->state }}">
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('Zip Code')</label>
                        <input type="text" class="form-control form--control" name="zip" value="{{ @$user->zip }}">
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('City')</label>
                        <input type="text" class="form-control form--control" name="city" value="{{ @$user->city }}">
                    </div>
                    <div class="col-md-6 mb-20">
                        <label class="form--label">@lang('Country')</label>
                        <input class="form-control form--control" value="{{ @$user->country_name }}" disabled>
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn cmn--btn w-100 justify-content-center" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        "use strict"
        var prevImg = $('.user-profile .thumb').html();

        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $('.user-profile').find('.thumb');
                    preview.html(`<img src="${e.target.result}" alt="user">`);
                    preview.addClass('has-image');
                    preview.hide();
                    preview.fadeIn(650);
                    $(".remove-image").show();
                    $(".show-image").hide();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#profile-image").on('change', function() {
            proPicURL(this);
        });
        $(".remove-image").on('click', function() {
            $(".user-profile .thumb").html(prevImg);
            $(".user-profile .thumb").removeClass('has-image');
            $(this).hide();
            $(".show-image").show();
        })
    </script>
@endpush
