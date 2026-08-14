@extends($activeTemplate . 'layouts.app')

@section('panel')
    <div class="account-section pt-70 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">

                    <div class="account__wrapper bg--section">
                        <div class="logo-mode logo">
                            <a href="{{ route('home') }}">
                                <img alt="logo">
                            </a>
                        </div>

                        @include($activeTemplate . 'partials.social_login')

                        <form class="account-form verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                            @csrf

                            <div class="form-group">
                                <label class="form--label" for="email">@lang('Username or Email')</label>
                                <input class="form-control form--control" name="username" type="text" value="{{ old('username') }}" required>
                            </div>

                            <div class="form-group">
                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                    <label class="form--label mb-0" for="password">@lang('Password')</label>
                                    <a class="fw-bold forgot-pass pt-1" href="{{ route('user.password.request') }}">
                                        @lang('Forgot your password?')
                                    </a>
                                </div>
                                <input class="form-control form--control" id="password" name="password" type="password" required>
                            </div>

                            <x-captcha />

                            <div class="form-group form-check my-2">
                                <input class="form-check-input" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    @lang('Remember Me')
                                </label>
                            </div>

                            <div class="form-group">
                                <button class="cmn--btn w-100 justify-content-center" id="recaptcha" type="submit">@lang('Sign In')</button>
                            </div>

                            <p class="mt-3">@lang('Don\'t have any account?') <a class="text--base" href="{{ route('user.register') }}">@lang('Create Account')</a></p>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
