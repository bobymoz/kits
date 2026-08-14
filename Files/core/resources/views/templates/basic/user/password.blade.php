@extends($activeTemplate . 'layouts.master')

@section('content')
    <section class="bg--section pb-3">
        <div class="card custom--card account__wrapper">
            <div class="px-3">
                <h3>@lang('Change Password')</h3>
            </div>
            <div class="card-body  ">

                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">@lang('Current Password')</label>
                        <input class="form-control form--control" name="current_password" type="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Password')</label>
                        <input class="form-control form--control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Confirm Password')</label>
                        <input class="form-control form--control" name="password_confirmation" type="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn cmn--btn w-100 justify-content-center" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
