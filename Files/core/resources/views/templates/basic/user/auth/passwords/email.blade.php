@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <div class="card custom--card account__wrapper bg--section">
                        <h5 class="pb-3 text-center border-bottom">{{ __($pageTitle) }}</h5>
                        
                        <div class="card-body">
                            <div class="mb-4">
                                <p class="pt-2">@lang('To recover your account please provide your email or username to find your account.')</p>
                            </div>
                            <form class="verify-gcaptcha" method="POST" action="{{ route('user.password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form--label">@lang('Email or Username')</label>
                                    <input class="form-control form--control" name="value" type="text" value="{{ old('value') }}" required autofocus="off">
                                </div>

                                <x-captcha />

                                <div class="form-group mt-3">
                                    <button class="btn cmn--btn justify-content-center w-100" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
