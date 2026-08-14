@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @php
        $content = getContent('contact_us.content', true);
        $contactElements = getContent('contact_us.element', false);
    @endphp

    <section class="contact-section pt-80 pb-80 bg--section">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="contact-contact">
                        <div class="section__header">
                            <h3 class="section__title mb-3">{{ __(@$content->data_values->heading) }}</h3>
                            <p>
                                {{ __(@$content->data_values->content) }}
                            </p>
                        </div>
                        <div class="maps"></div>
                    </div>
                </div>
                <div class="col-lg-6 ps-xl-5">
                    <div class="account__wrapper bg--body">
                        <form class="account-form verify-gcaptcha" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="form--label">@lang('Name')</label>
                                <input class="form-control form--control" name="name" type="text" value="{{ old('name', @$user->fullname) }}" @if ($user && $user->profile_complete) readonly @endif required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Email')</label>
                                <input class="form-control form--control" name="email" type="email" value="{{ old('email', @$user->email) }}" @if ($user) readonly @endif required>
                            </div>
                            <div class="form-group">
                                <label class="form--label">@lang('Subject')</label>
                                <input class="form-control form--control" name="subject" type="text" value="{{ old('subject') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form--label">@lang('Message')</label>
                                <textarea class="form-control form--control" name="message" required>{{ old('message') }}</textarea>
                            </div>
                            <x-captcha />
                            <div class="form-group pt-3">
                                <button class="btn cmn--btn justify-content-center w-100" type="submit">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="contact-info-section pb-80 bg--section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach ($contactElements as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="contact__item bg--body h-100">
                            <div class="contact__item-icon">
                                @php echo @$item->data_values->icon @endphp
                            </div>
                            <h5 class="title">{{ __(@$item->data_values->title) }}</h5>

                            <ul>
                                <li>
                                    <a href="javascript:void(0)">{{ __(@$item->data_values->content) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script-lib')
    <script src="https://maps.google.com/maps/api/js?key={{ @$content->data_values->map_key }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/map.js') }}"></script>
@endpush

@push('script')
    <script>
        var mapOptions = {
            center: new google.maps.LatLng({{ @$content->data_values->latitude }}, {{ @$content->data_values->longitude }}),
            zoom: 10,
            styles: styleArray,
            scrollwheel: false,
            backgroundColor: '#e5ecff',
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
            mapOptions);
        var myLatlng = new google.maps.LatLng({{ @$content->data_values->latitude }}, {{ @$content->data_values->longitude }});
        var focusplace = {
            lat: {{ @$content->data_values->latitude }},
            lng: {{ @$content->data_values->longitude }}
        };
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: {
                url: "{{ asset($activeTemplateTrue . 'images/map-marker.png') }}"
            }
        });
    </script>
@endpush
