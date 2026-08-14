@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')

    <section class="bg--section pt-80 pb-80">
        <div class="container">

                <div class="row">

                    <div class="col-xl-3">
                        <div class="dashboard-menu-open d-xl-none">
                            <i class="las la-ellipsis-v"></i>
                        </div>
                        @include($activeTemplate . 'partials.sidenav')
                    </div>

                    <div class="col-xl-9">
                        @yield('content')
                    </div>
                </div>

        </div>
    </section>

    @include($activeTemplate . 'partials.footer')
@endsection
