@php
    $blog = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp

<section class="bg--section pt-80 pb-80">
    <div class="section--wrapper">

        @include($activeTemplate . 'partials.leftbar')

        <div class="container wrapper-inner">
            @php echo getAdvertisement('1188x80') @endphp

            <div class="row g-4 justify-content-center mt-2">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="post__item">
                            <div class="post__thumb">
                                <a href="{{ route('blog.details', $blog->slug) }}">
                                    <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '440x210') }}" alt="">
                                </a>
                                <span class="category">
                                    {{ __(@$item->data_values->category) }}
                                </span>
                            </div>
                            <div class="post__content">
                                <h6 class="post__title">
                                    <a href="{{ route('blog.details', $blog->slug) }}">{{ strLimit(__(@$blog->data_values->title), 60) }}</a>
                                </h6>
                                <div class="meta__date">
                                    <div class="meta__item">
                                        <i class="las la-calendar"></i>
                                        {{ showDateTime(@$blog->created_at, 'd F, Y') }}
                                    </div>
                                    <div class="meta__item">
                                        <i class="las la-user"></i>
                                        @lang('Author')
                                    </div>
                                </div>
                                <a class="post__read" href="{{ route('blog.details', $blog->slug) }}">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @php echo getAdvertisement('3033x375') @endphp
        </div>

        @include($activeTemplate . 'partials.rightbar')

    </div>
</section>
