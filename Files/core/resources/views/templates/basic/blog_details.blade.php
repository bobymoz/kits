
@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="bg--section pt-80 pb-80">
        <div class="section--wrapper">

            @include($activeTemplate.'partials.leftbar')

            <div class="container wrapper-inner">
                @php echo getAdvertisement('1188x80') @endphp

                <div class="row gy-5 justify-content-center pt-3">
                    <div class="col-lg-8">
                        <div class="post__details pb-50">
                            <div class="post__header">
                                <h3 class="post__title pt-5">
                                    {{__($blog->data_values->title)}}
                                </h3>
                                <div class="post__thumb">
									<img src="{{ frontendImage('blog' , @$blog->data_values->image, '875x420') }}" alt="">
                                </div>

                                <div class="blog-description">
                                    @php echo @$blog->data_values->description @endphp
                                </div>
                            </div>

                            <div class="row gy-4 justify-content-between ">
                                <div class="col-md-12">
                                    <h6 class="post__share__title">@lang('Share now')</h6>
                                    <ul class="post__share">
                                        <li>
                                            <a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug(@$blog->data_values->title)}}" target="_blank" title="@lang('Facebook')"><i class="lab la-facebook-f"></i></a>
                                        </li>
                                        <li>
                                            <a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug(@$blog->data_values->title)}}" target="_blank" title="@lang('Twitter')"><i class="lab la-pinterest-p"></i></a>
                                        </li>
                                        <li>
                                            <a href="http://twitter.com/share?text={{slug(@$blog->data_values->title)}}&url={{urlencode(url()->current()) }}" target="_blank" title="@lang('Twitter')"><i class="lab la-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug(@$blog->data_values->title)}}" target="_blank" title="@lang('Linkedin')"><i class="lab la-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <aside class="blog-sidebar bg--body">
                            <div class="widget widget__post__area">
                                <h5 class="widget__title">@lang('Recent Posts')</h5>
                                <ul>
                                    @foreach($blogElements as $item)
                                        <li>
                                            <a href="{{ route('blog.details',[slug(__(@$item->data_values->title)),$item->id]) }}" class="widget__post">
                                                <div class="widget__post__thumb">
													<img src="{{ frontendImage('blog', 'thumb_' . @$item->data_values->image, '440x210') }}" alt="">
                                                </div>
                                                <div class="widget__post__content">
                                                    <h6 class="widget__post__title">
                                                        {{strLimit(__(@$item->data_values->title),45)}}
                                                    </h6>
                                                    <span>{{showDateTime(@$item->created_at,'d F, Y')}}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>

                @php echo getAdvertisement('3033x375') @endphp
            </div>

            @include($activeTemplate.'partials.rightbar')
        </div>
    </section>

@endsection


