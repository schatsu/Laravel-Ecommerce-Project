@extends('app.layouts.main')
@section('title', 'Kategoriler')
@section('content')
    <!-- Banner Collection -->
    <div class="blog-grid-main">
        <div class="container">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="blog-article-item">
                            <div class="article-thumb">
                                <a href="{{route('category.show', ['slug' => $category?->slug])}}">
                                    <img class="lazyload" data-src="{{ $category?->getFirstMediaUrl('collection_cover', 'collection_cover') }}" src="{{ $category?->getFirstMediaUrl('collection_cover', 'collection_cover') }}"
                                         alt="img-blog">
                                </a>
                                <div class="article-label">
                                    <a href="{{route('category.show', ['slug' => $category?->slug])}}"
                                       class="tf-btn btn-sm radius-3 btn-fill animate-hover-btn">{{$category?->name}}</a>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-title">
                                    <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="">The next generation of leather alternatives</a>
                                </div>
                                <div class="article-btn">
                                    <a href="{{route('category.show', ['slug' => $category?->slug])}}" class="tf-btn btn-line fw-6">Alışverişe Başla<i
                                            class="icon icon-arrow1-top-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center align-items-center mt-4">
                    {{$categories->links('pagination::custom-pagination')}}
                </div>
            </div>
        </div>
    </div>
    <!-- /Banner Collection -->
@endsection

