@php
    $about = getContent('about.content', true);
@endphp

<section class="about-section my-5 position-relative">
    <div class="container position-relative">
        <div class="row gy-5 justify-content-between flex-wrap-reverse align-items-center">
            <div class="col-lg-6">
                <div class="section__header">
                    <h2 class="section__title">{{ __(@$about->data_values->heading) }}</h2>
                </div>
                <div class="about__txt pt-4">
                    <p>{{ __(@$about->data_values->content) }}</p>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="choose-thumb">
                    <img src="{{ frontendImage('about', @$about->data_values->image, '837x554') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
