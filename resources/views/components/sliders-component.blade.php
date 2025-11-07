<div>
    <!-- slider -->
    <div class="tf-slideshow slider-women slider-effect-fade position-relative">
        <div dir="ltr" class="swiper tf-sw-slideshow" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-loop="true" data-auto-play="false" data-delay="2000" data-speed="1000">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide" lazy="true">
                        <div class="wrap-slider">
                            <img class="lazyload" data-src="{{asset('storage/'. $slider?->image) ?: 'https://placehold.co/2000x732'}}" src="{{asset('storage/'. $slider?->image) ?: 'https://placehold.co/2000x732'}}" alt="{{$slider?->title ?? ''}}" >
                            <div class="box-content">
                                <div class="container">
                                    <h1 class="fade-item fade-item-1">{{$slider?->title}}</h1>
                                    <p class="fade-item fade-item-2">{{$slider?->subtitle}}</p>
                                    <a href="{{$slider?->link_url ?? ''}}" class="fade-item fade-item-3 tf-btn btn-fill animate-hover-btn btn-xl radius-60"><span>{{$slider?->link_title ?? ''}}</span><i class="icon icon-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="wrap-pagination">
            <div class="container">
                <div class="sw-dots sw-pagination-slider justify-content-center"></div>
            </div>
        </div>
    </div>
    <!-- /slider -->
</div>
