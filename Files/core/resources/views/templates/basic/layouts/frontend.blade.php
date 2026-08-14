@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')

    @yield('content')

    @include($activeTemplate . 'partials.footer')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.click-Up').on('click', function() {

                var id = $(this).data('id');

                var url = "{{ route('add.clickup') }}";
                var data = {
                    id: id
                };

                $.get(url, data, function(response) {

                    if (response.id) {
                        $.each(response.id, function(i, val) {
                            notify('error', val);
                        });
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
