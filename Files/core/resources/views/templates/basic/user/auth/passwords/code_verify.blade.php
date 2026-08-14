@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <div class="pt-80 pb-80">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">

                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper account__wrapper bg--section">
                            <div class="verification-area">
                                <h5 class="pb-3 text-center border-bottom">@lang('Verify Email Address')</h5>
                                <form class="submit-form" action="{{ route('user.password.verify.code') }}" method="POST">
                                    @csrf
                                    <p class="verification-text mt-2">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                    <input name="email" type="hidden" value="{{ $email }}">
                                    @include($activeTemplate . 'partials.verification_code')
                                    <div class="form-group">
                                        <button class="btn cmn--btn justify-content-center w-100" type="submit">@lang('Submit')</button>
                                    </div>
                                    <div class="form-group">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
