<section class="flat-spacing-5 pb_0">
    <div class="container">
        <div class="flat-title">
            <span class="title wow fadeInUp" data-wow-delay="0s">Hoşunuza gidebilecek kategoriler</span>
        </div>
        <div class="hover-sw-nav">
            <div dir="ltr" class="swiper tf-sw-collection" data-preview="4" data-tablet="2" data-mobile="2" data-space-lg="30" data-space-md="30" data-space="15" data-loop="false" data-auto-play="false">
                <div class="swiper-wrapper">
                    @forelse($categories as $category)
                        <div class="swiper-slide" lazy="true">
                            <div class="collection-item style-2 hover-img">
                                <div class="collection-inner">
                                    <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="collection-image img-style">
                                        <img class="lazyload" data-src="{{ $category?->getFirstMediaUrl('landing_cover', 'landing_cover') }}" src="{{ $category?->getFirstMediaUrl('landing_cover', 'landing_cover') }}" alt="collection-img">
                                    </a>
                                    <div class="collection-content">
                                        <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="tf-btn collection-title hover-icon fs-15 rounded-full"><span>{{$category?->name}}</span><i class="icon icon-arrow1-top-left"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="nav-sw nav-next-slider nav-next-collection box-icon w_46 round"><span class="icon icon-arrow-left"></span></div>
            <div class="nav-sw nav-prev-slider nav-prev-collection box-icon w_46 round"><span class="icon icon-arrow-right"></span></div>
            <div class="sw-dots style-2 sw-pagination-collection justify-content-center"></div>
        </div>
    </div>
</section>
<!-- Banner Collection -->
<section class="flat-spacing-10 pb_0">
    <div class="container">
        <div dir="ltr" class="swiper tf-sw-recent" data-preview="2" data-tablet="2" data-mobile="1.3" data-space-lg="30" data-space-md="15" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                    <div class="swiper-slide" lazy="true">
                        <div class="collection-item-v4 hover-img">
                            <div class="collection-inner">
                                <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="collection-image img-style radius-10">
                                    <img class="lazyload" data-src="{{ $category?->getFirstMediaUrl('collection_cover', 'collection_cover') }}" src="{{ $category?->getFirstMediaUrl('collection_cover', 'collection_cover') }}" alt="collection-img">
                                </a>
                                <div class="collection-content wow fadeInUp" data-wow-delay="0s">
                                    <h5 class="heading text_white">{{$category?->name}}</h5>
                                    <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="tf-btn style-3 fw-6 btn-light-icon rounded-full animate-hover-btn"><span>Alışverişe başla</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /Banner Collection -->
