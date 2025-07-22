<div>
    <section class="flat-spacing-20">
        <div class="container">
            <div class="tf-categories-wrap">
                <div class="tf-categories-container">
                    @forelse($categories as $category)
                        <div class="collection-item-circle hover-img">
                            <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="collection-image img-style">
                                <img class="lazyload border border-3 rounded-circle" data-src="{{ asset($category?->image_url) }}" src="{{ asset( $category?->image_url) }}" alt="c{{$category?->name}}">
                            </a>
                            <div class="collection-content text-center">
                                <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="link title fw-6">{{$category?->name}}</a>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="tf-shopall-wrap">
                    <div class="collection-item-circle tf-shopall">
                        <a href="{{route('category.index')}}" class="collection-image img-style tf-shopall-icon">
                            <i class="icon icon-arrow1-top-left"></i>
                        </a>
                        <div class="collection-content text-center">
                            <a href="{{route('category.index')}}" class="link title fw-6">Tümü</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
