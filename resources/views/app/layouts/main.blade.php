<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Ata Silver | @yield('title')</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- font -->
    <link rel="stylesheet" href="{{asset('front/fonts/fonts.css')}}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('front/fonts/font-icons.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('front/css/styles.css')}}"/>
    @stack('css')

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{asset('front/images/logo/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('front/images/logo/favicon.png')}}">

</head>

<body class="preload-wrapper">
<!-- RTL -->
<!-- <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-hover-btn btn-fill">RTL</a> -->
<!-- /RTL  -->
<!-- preload -->
<div class="preload preload-container">
    <div class="preload-logo">
        <div class="spinner"></div>
    </div>
</div>
<!-- /preload -->
<div id="wrapper">
    <!-- announcement-bar -->
    <div class="announcement-bar bg_dark">
        <div class="wrap-announcement-bar">
            <div class="box-sw-announcement-bar speed-1">
                <div class="announcement-bar-item">
                    <p>FREE SHIPPING AND RETURNS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>NEW SEASON, NEW STYLES: FASHION SALE YOU CAN'T MISS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>LIMITED TIME OFFER: FASHION SALE YOU CAN'T RESIST</p>
                </div>
                <div class="announcement-bar-item">
                    <p>FREE SHIPPING AND RETURNS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>NEW SEASON, NEW STYLES: FASHION SALE YOU CAN'T MISS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>LIMITED TIME OFFER: FASHION SALE YOU CAN'T RESIST</p>
                </div>
                <div class="announcement-bar-item">
                    <p>FREE SHIPPING AND RETURNS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>NEW SEASON, NEW STYLES: FASHION SALE YOU CAN'T MISS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>LIMITED TIME OFFER: FASHION SALE YOU CAN'T RESIST</p>
                </div>
                <div class="announcement-bar-item">
                    <p>FREE SHIPPING AND RETURNS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>NEW SEASON, NEW STYLES: FASHION SALE YOU CAN'T MISS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>LIMITED TIME OFFER: FASHION SALE YOU CAN'T RESIST</p>
                </div>
                <div class="announcement-bar-item">
                    <p>FREE SHIPPING AND RETURNS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>NEW SEASON, NEW STYLES: FASHION SALE YOU CAN'T MISS</p>
                </div>
                <div class="announcement-bar-item">
                    <p>LIMITED TIME OFFER: FASHION SALE YOU CAN'T RESIST</p>
                </div>
            </div>
        </div>
        <span class="icon-close close-announcement-bar"></span>

    </div>
    <!-- /announcement-bar -->

    <!-- header -->
    @include('app.layouts.header')
    <!-- /header -->

    @yield('content')

    <!-- footer -->
    @include('app.layouts.footer')
    <!-- /footer -->

</div>

<!-- gotop -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;"></path>
    </svg>
</div>
<!-- /gotop -->

<!-- toolbar-bottom -->
<div class="tf-toolbar-bottom type-1150">
    <div class="toolbar-item">
        <a href="#toolbarShopmb" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
            <div class="toolbar-icon">
                <i class="icon-shop"></i>
            </div>
            <div class="toolbar-label">Shop</div>
        </a>
    </div>

    <div class="toolbar-item">
        <a href="#canvasSearch" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
            <div class="toolbar-icon">
                <i class="icon-search"></i>
            </div>
            <div class="toolbar-label">Search</div>
        </a>
    </div>
    <div class="toolbar-item">
        <a href="#login" data-bs-toggle="modal">
            <div class="toolbar-icon">
                <i class="icon-account"></i>
            </div>
            <div class="toolbar-label">Account</div>
        </a>
    </div>
    <div class="toolbar-item">
        <a href="wishlist.html">
            <div class="toolbar-icon">
                <i class="icon-heart"></i>
                <div class="toolbar-count">0</div>
            </div>
            <div class="toolbar-label">Wishlist</div>
        </a>
    </div>
    <div class="toolbar-item">
        <a href="#shoppingCart" data-bs-toggle="modal">
            <div class="toolbar-icon">
                <i class="icon-bag"></i>
                <div class="toolbar-count">1</div>
            </div>
            <div class="toolbar-label">Cart</div>
        </a>
    </div>
</div>
<!-- /toolbar-bottom -->

<!-- modalDemo -->
<div class="modal fade modalDemo" id="modalDemo">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <h5 class="demo-title">Ultimate HTML Theme</h5>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="mega-menu">
                <div class="row-demo">
                    <div class="demo-item">
                        <a href="index.html">
                            <div class="demo-image position-relative">
                                <img class="lazyload" data-src="{{asset('front/images/demo/home-01.jpg')}}" src="{{asset('front/images/demo/home-01.jpg')}}" alt="home-01">
                                <div class="demo-label">
                                    <span class="demo-new">New</span>
                                    <span>Trend</span>
                                </div>
                            </div>
                            <span class="demo-name">Home Fashion 01</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /modalDemo -->

<!-- mobile menu -->
<div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
    <div class="mb-canvas-content">
        <div class="mb-body">
            <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                <li class="nav-mb-item">
                    <a href="#dropdown-menu-one" class="collapsed mb-menu-link current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dropdown-menu-one">
                        <span>Home</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="dropdown-menu-one" class="collapse">
                        <ul class="sub-nav-menu" >
                            <li><a href="index.html" class="sub-nav-link">Home Fashion 01</a></li>
                            <li><a href="home-02.html" class="sub-nav-link">Home Fashion 02</a></li>
                            <li><a href="home-03.html" class="sub-nav-link">Home Fashion 03</a></li>
                            <li><a href="home-04.html" class="sub-nav-link">Home Fashion 04</a></li>
                            <li><a href="home-05.html" class="sub-nav-link">Home Fashion 05</a></li>
                            <li><a href="home-06.html" class="sub-nav-link">Home Fashion 06</a></li>
                            <li><a href="home-07.html" class="sub-nav-link">Home Fashion 07</a></li>
                            <li><a href="home-08.html" class="sub-nav-link">Home Fashion 08</a></li>
                            <li><a href="home-giftcard.html" class="sub-nav-link">Home Gift Card</a></li>
                            <li><a href="home-headphone.html" class="sub-nav-link">Home Headphone</a></li>
                            <li><a href="home-multi-brand.html" class="sub-nav-link">Home Multi Brand</a></li>
                            <li><a href="home-skincare.html" class="sub-nav-link">Home skincare</a></li>
                            <li><a href="home-furniture.html" class="sub-nav-link">Home Furniture</a></li>
                            <li><a href="home-furniture-02.html" class="sub-nav-link">Home Furniture 2</a></li>
                            <li><a href="home-skateboard.html" class="sub-nav-link">Home Skateboard</a></li>
                            <li><a href="home-stroller.html" class="sub-nav-link">Home Stroller</a></li>
                            <li><a href="home-decor.html" class="sub-nav-link">Home Decor</a></li>
                            <li><a href="home-electronic.html" class="sub-nav-link">Home Electronic</a></li>
                            <li><a href="home-setup-gear.html" class="sub-nav-link">Home Setup Gear</a></li>
                            <li><a href="home-dog-accessories.html" class="sub-nav-link">Home Dog Accessories</a></li>
                            <li><a href="home-kitchen-wear.html" class="sub-nav-link">Home Kitchen Wear</a></li>
                            <li><a href="home-phonecase.html" class="sub-nav-link">Home Phonecase</a></li>
                            <li><a href="home-paddle-boards.html" class="sub-nav-link">Home Paddle Boards</a></li>
                            <li><a href="home-glasses.html" class="sub-nav-link">Home Glasses</a></li>
                            <li><a href="home-pod-store.html" class="sub-nav-link">Home POD Store</a></li>
                            <li><a href="home-activewear.html" class="sub-nav-link">Home Activewear</a></li>
                            <li><a href="home-handbag.html" class="sub-nav-link">Home Handbag</a></li>
                            <li><a href="home-tee.html" class="sub-nav-link">Home Tee</a></li>
                            <li><a href="home-sock.html" class="sub-nav-link">Home Sock</a></li>
                            <li><a href="home-jewerly.html" class="sub-nav-link">Home Jewelry</a></li>
                            <li><a href="home-sneaker.html" class="sub-nav-link">Home Sneaker</a></li>
                            <li><a href="home-accessories.html" class="sub-nav-link">Home Accessories</a></li>
                            <li><a href="home-grocery.html" class="sub-nav-link">Home Grocery</a></li>
                            <li><a href="home-baby.html" class="sub-nav-link">Home Baby</a></li>
                            <li><a href="home-personalized-pod.html" class="sub-nav-link">Home Personalized Pod</a></li>
                            <li><a href="home-pickleball.html" class="sub-nav-link">Home Pickleball</a></li>
                            <li><a href="home-ceramic.html" class="sub-nav-link">Home Ceramic</a></li>
                            <li><a href="home-food.html" class="sub-nav-link">Home Food</a></li>
                            <li><a href="home-camp-and-hike.html" class="sub-nav-link">Home Camp And Hike</a></li>
                        </ul>
                    </div>

                </li>
                <li class="nav-mb-item">
                    <a href="#dropdown-menu-two" class="collapsed mb-menu-link current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dropdown-menu-two">
                        <span>Shop</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="dropdown-menu-two" class="collapse">
                        <ul class="sub-nav-menu" id="sub-menu-navigation">
                            <li><a href="#sub-shop-one" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-shop-one">
                                    <span>Shop layouts</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-shop-one" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="shop-default.html" class="sub-nav-link">Default</a></li>
                                        <li><a href="shop-left-sidebar.html" class="sub-nav-link">Left sidebar</a></li>
                                        <li><a href="shop-right-sidebar.html" class="sub-nav-link">Right sidebar</a></li>
                                        <li><a href="shop-fullwidth.html" class="sub-nav-link">Fullwidth</a></li>
                                        <li><a href="shop-collection-sub.html" class="sub-nav-link">Sub collection</a></li>
                                        <li><a href="shop-collection-list.html" class="sub-nav-link">Collections list</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#sub-shop-two" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-shop-two">
                                    <span>Features</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-shop-two" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="shop-link.html" class="sub-nav-link">Pagination links</a></li>
                                        <li><a href="shop-loadmore.html" class="sub-nav-link">Pagination loadmore</a></li>
                                        <li><a href="shop-infinite-scrolling.html" class="sub-nav-link">Pagination infinite scrolling</a></li>
                                        <li><a href="shop-filter-sidebar.html" class="sub-nav-link">Filter sidebar</a></li>
                                        <li><a href="shop-filter-hidden.html" class="sub-nav-link">Filter hidden</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#sub-shop-three" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-shop-three">
                                    <span>Product styles</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-shop-three" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">

                                        <li><a href="product-style-01.html" class="sub-nav-link">Product style 01</a></li>
                                        <li><a href="product-style-02.html" class="sub-nav-link">Product style 02</a></li>
                                        <li><a href="product-style-03.html" class="sub-nav-link">Product style 03</a></li>
                                        <li><a href="product-style-04.html" class="sub-nav-link">Product style 04</a></li>
                                        <li><a href="product-style-05.html" class="sub-nav-link">Product style 05</a></li>
                                        <li><a href="product-style-06.html" class="sub-nav-link">Product style 06</a></li>
                                        <li><a href="product-style-07.html" class="sub-nav-link">Product style 07</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-mb-item">
                    <a href="#dropdown-menu-three" class="collapsed mb-menu-link current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dropdown-menu-three">
                        <span>Products</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="dropdown-menu-three" class="collapse">
                        <ul class="sub-nav-menu" id="sub-menu-navigation">
                            <li>
                                <a href="#sub-product-one" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-product-one">
                                    <span>Product layouts</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-product-one" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="product-detail.html" class="sub-nav-link">Product default</a></li>
                                        <li><a href="product-grid-1.html" class="sub-nav-link">Product grid 1</a></li>
                                        <li><a href="product-grid-2.html" class="sub-nav-link">Product grid 2</a></li>
                                        <li><a href="product-stacked.html" class="sub-nav-link">Product stacked</a></li>
                                        <li><a href="product-right-thumbnails.html" class="sub-nav-link">Product right thumbnails</a></li>
                                        <li><a href="product-bottom-thumbnails.html" class="sub-nav-link">Product bottom thumbnails</a></li>
                                        <li><a href="product-drawer-sidebar.html" class="sub-nav-link">Product drawer sidebar</a></li>
                                        <li><a href="product-description-accordion.html" class="sub-nav-link">Product description accordion</a></li>
                                        <li><a href="product-description-list.html" class="sub-nav-link">Product description list</a></li>
                                        <li><a href="product-description-vertical.html" class="sub-nav-link">Product description vertical</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#sub-product-two" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-product-two">
                                    <span>Product details</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-product-two" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="product-inner-zoom.html" class="sub-nav-link">Product inner zoom</a></li>
                                        <li><a href="product-zoom-magnifier.html" class="sub-nav-link">Product zoom magnifier</a></li>
                                        <li><a href="product-no-zoom.html" class="sub-nav-link">Product no zoom</a></li>
                                        <li><a href="product-photoswipe-popup.html" class="sub-nav-link">Product photoswipe popup</a></li>
                                        <li><a href="product-zoom-popup.html" class="sub-nav-link">Product external zoom and photoswipe popup</a></li>
                                        <li><a href="product-video.html" class="sub-nav-link">Product video</a></li>
                                        <li><a href="product-3d.html" class="sub-nav-link">Product 3D, AR models</a></li>
                                        <li><a href="product-options-customizer.html" class="sub-nav-link">Product options & customizer</a></li>
                                        <li><a href="product-advanced-types.html" class="sub-nav-link">Advanced product types</a></li>
                                        <li><a href="product-giftcard.html" class="sub-nav-link">Recipient information form for gift card products</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#sub-product-three" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-product-three">
                                    <span>Product swatchs</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-product-three" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="product-color-swatch.html" class="sub-nav-link">Product color swatch</a></li>
                                        <li><a href="product-rectangle.html" class="sub-nav-link">Product rectangle</a></li>
                                        <li><a href="product-rectangle-color.html" class="sub-nav-link">Product rectangle color</a></li>
                                        <li><a href="product-swatch-image.html" class="sub-nav-link">Product swatch image</a></li>
                                        <li><a href="product-swatch-image-rounded.html" class="sub-nav-link">Product swatch image rounded</a></li>
                                        <li><a href="product-swatch-dropdown.html" class="sub-nav-link">Product swatch dropdown</a></li>
                                        <li><a href="product-swatch-dropdown-color.html" class="sub-nav-link">Product swatch dropdown color</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#sub-product-four" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-product-four">
                                    <span>Product features</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-product-four" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="product-frequently-bought-together.html" class="sub-nav-link">Frequently bought together</a></li>
                                        <li><a href="product-frequently-bought-together-2.html" class="sub-nav-link">Frequently bought together 2</a></li>
                                        <li><a href="product-upsell-features.html" class="sub-nav-link">Product upsell features</a></li>
                                        <li><a href="product-pre-orders.html" class="sub-nav-link">Product pre-orders</a></li>
                                        <li><a href="product-notification.html" class="sub-nav-link">Back in stock notification</a></li>
                                        <li><a href="product-pickup.html" class="sub-nav-link">Product pickup</a></li>
                                        <li><a href="product-images-grouped.html" class="sub-nav-link">Variant images grouped</a></li>
                                        <li><a href="product-complimentary.html" class="sub-nav-link">Complimentary products</a></li>
                                        <li><a href="product-quick-order-list.html" class="sub-nav-link line-clamp">Quick order list<div class="demo-label"><span class="demo-new">New</span></div></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-mb-item">
                    <a href="#dropdown-menu-four" class="collapsed mb-menu-link current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dropdown-menu-four">
                        <span>Pages</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="dropdown-menu-four" class="collapse">
                        <ul class="sub-nav-menu" id="sub-menu-navigation">
                            <li><a href="about-us.html" class="sub-nav-link">About us</a></li>
                            <li><a href="brands.html" class="sub-nav-link line-clamp">Brands<div class="demo-label"><span class="demo-new">New</span></div></a></li>
                            <li><a href="brands-v2.html" class="sub-nav-link">Brands V2</a></li>
                            <li><a href="contact-1.html" class="sub-nav-link">Contact 1</a></li>
                            <li><a href="contact-2.html" class="sub-nav-link">Contact 2</a></li>
                            <li><a href="faq-1.html" class="sub-nav-link">FAQ 01</a></li>
                            <li><a href="faq-2.html" class="sub-nav-link">FAQ 02</a></li>
                            <li><a href="our-store.html" class="sub-nav-link">Our store</a></li>
                            <li><a href="store-locations.html" class="sub-nav-link">Store locator</a></li>
                            <li><a href="timeline.html" class="sub-nav-link line-clamp">Timeline<div class="demo-label"><span class="demo-new">New</span></div></a></li>
                            <li><a href="view-cart.html" class="sub-nav-link line-clamp">View cart</a></li>
                            <li><a href="checkout.html" class="sub-nav-link line-clamp">Check out</a></li>
                            <li><a href="payment-confirmation.html" class="sub-nav-link line-clamp">Payment Confirmation</a></li>
                            <li><a href="payment-failure.html" class="sub-nav-link line-clamp">Payment Failure</a></li>
                            <li><a href="#sub-account" class="sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="sub-account">
                                    <span>My Account</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="sub-account" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li><a href="my-account.html" class="sub-nav-link">My account</a></li>
                                        <li><a href="my-account-orders.html" class="sub-nav-link">My order</a></li>
                                        <li><a href="my-account-orders-details.html" class="sub-nav-link">My order details</a></li>
                                        <li><a href="my-account-address.html" class="sub-nav-link">My address</a></li>
                                        <li><a href="my-account-edit.html" class="sub-nav-link">My account details</a></li>
                                        <li><a href="my-account-wishlist.html" class="sub-nav-link">My wishlist</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="invoice.html" class="sub-nav-link line-clamp">Invoice</a></li>
                            <li><a href="404.html" class="sub-nav-link line-clamp">404</a></li>
                        </ul>
                    </div>

                </li>
                <li class="nav-mb-item">
                    <a href="#dropdown-menu-five" class="collapsed mb-menu-link current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dropdown-menu-five">
                        <span>Blog</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="dropdown-menu-five" class="collapse">
                        <ul class="sub-nav-menu" >
                            <li><a href="blog-grid.html" class="sub-nav-link">Grid layout</a></li>
                            <li><a href="blog-sidebar-left.html" class="sub-nav-link">Left sidebar</a></li>
                            <li><a href="blog-sidebar-right.html" class="sub-nav-link">Right sidebar</a></li>
                            <li><a href="blog-list.html" class="sub-nav-link">Blog list</a></li>
                            <li><a href="blog-detail.html" class="sub-nav-link">Single Post</a></li>
                        </ul>
                    </div>

                </li>
                <li class="nav-mb-item">
                    <a href="https://themeforest.net/item/ecomus-ultimate-html5-template/53417990?s_rank=3" class="mb-menu-link">Buy now</a>
                </li>
            </ul>
            <div class="mb-other-content">
                <div class="d-flex group-icon">
                    <a href="wishlist.html" class="site-nav-icon"><i class="icon icon-heart"></i>Wishlist</a>
                    <a href="home-search.html" class="site-nav-icon"><i class="icon icon-search"></i>Search</a>
                </div>
                <div class="mb-notice">
                    <a href="contact-1.html" class="text-need">Need help ?</a>
                </div>
                <ul class="mb-info">
                    <li>Address: 1234 Fashion Street, Suite 567, <br> New York, NY 10001</li>
                    <li>Email: <b>info@fashionshop.com</b></li>
                    <li>Phone: <b>(212) 555-1234</b></li>
                </ul>
            </div>
        </div>
        <div class="mb-bottom">
            <a href="{{route('login')}}" class="site-nav-icon"><i class="icon icon-account"></i>Giriş Yap</a>
            <div class="bottom-bar-language">
                <div class="tf-currencies">
                    <select class="image-select center style-default type-currencies">
                        <option data-thumbnail="{{asset('front/images/country/fr.svg')}}">EUR <span>€ | France</span></option>
                        <option data-thumbnail="{{asset('front/images/country/de.svg')}}">EUR <span>€ | Germany</span></option>
                        <option selected data-thumbnail="{{asset('front/images/country/us.svg')}}">USD <span>$ | United States</span></option>
                        <option data-thumbnail="{{asset('front/images/country/vn.svg')}}">VND <span>₫ | Vietnam</span></option>
                    </select>
                </div>
                <div class="tf-languages">
                    <select class="image-select center style-default type-languages">
                        <option>English</option>
                        <option>العربية</option>
                        <option>简体中文</option>
                        <option>اردو</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /mobile menu -->

<!-- canvasSearch -->
<div class="offcanvas offcanvas-end canvas-search" id="canvasSearch">
    <div class="canvas-wrapper">
        <header class="tf-search-head">
            <div class="title fw-5">
                Search our site
                <div class="close">
                    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
                </div>
            </div>
            <div class="tf-search-sticky">
                <form class="tf-mini-search-frm">
                    <fieldset class="text">
                        <input type="text" placeholder="Search" class="" name="text" tabindex="0" value="" aria-required="true" required="">
                    </fieldset>
                    <button class="" type="submit"><i class="icon-search"></i></button>
                </form>
            </div>
        </header>
        <div class="canvas-body p-0">
            <div class="tf-search-content">
                <div class="tf-cart-hide-has-results">
                    <div class="tf-col-quicklink">
                        <div class="tf-search-content-title fw-5">Quick link</div>
                        <ul class="tf-quicklink-list">
                            <li class="tf-quicklink-item">
                                <a href="shop-default.html" class="">Fashion</a>
                            </li>
                            <li class="tf-quicklink-item">
                                <a href="shop-default.html" class="">Men</a>
                            </li>
                            <li class="tf-quicklink-item">
                                <a href="shop-default.html" class="">Women</a>
                            </li>
                            <li class="tf-quicklink-item">
                                <a href="shop-default.html" class="">Accessories</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tf-col-content">
                        <div class="tf-search-content-title fw-5">Need some inspiration?</div>
                        <div class="tf-search-hidden-inner">
                            <div class="tf-loop-item">
                                <div class="image">
                                    <a href="product-detail.html">
                                        <img src="{{asset('front/images/products/white-3.jpg')}}" alt="">
                                    </a>
                                </div>
                                <div class="content">
                                    <a href="product-detail.html">Cotton jersey top</a>
                                    <div class="tf-product-info-price">
                                        <div class="compare-at-price">$10.00</div>
                                        <div class="price-on-sale fw-6">$8.00</div>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-loop-item">
                                <div class="image">
                                    <a href="product-detail.html">
                                        <img src="{{asset('front/images/products/white-2.jpg')}}" alt="">
                                    </a>
                                </div>
                                <div class="content">
                                    <a href="product-detail.html">Mini crossbody bag</a>
                                    <div class="tf-product-info-price">
                                        <div class="price fw-6">$18.00</div>
                                    </div>
                                </div>
                            </div>
                            <div class="tf-loop-item">
                                <div class="image">
                                    <a href="product-detail.html">
                                        <img src="{{asset('front/images/products/white-1.jpg')}}" alt="">
                                    </a>
                                </div>
                                <div class="content">
                                    <a href="product-detail.html">Oversized Printed T-shirt</a>
                                    <div class="tf-product-info-price">
                                        <div class="price fw-6">$18.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /canvasSearch -->

<!-- toolbarShopmb -->
<div class="offcanvas offcanvas-start canvas-mb toolbar-shop-mobile" id="toolbarShopmb">
    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
    <div class="mb-canvas-content">
        <div class="mb-body">
            <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                <li class="nav-mb-item">
                    <a href="shop-default.html" class="tf-category-link mb-menu-link">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate1.jpg')}}" alt="">
                        </div>
                        <span>Accessories</span>
                    </a>
                </li>
                <li class="nav-mb-item">
                    <a href="shop-default.html" class="tf-category-link mb-menu-link">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate2.jpg')}}" alt="">
                        </div>
                        <span>Dog</span>
                    </a>
                </li>
                <li class="nav-mb-item">
                    <a href="shop-default.html" class="tf-category-link mb-menu-link">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate3.jpg')}}" alt="">
                        </div>
                        <span>Grocery</span>
                    </a>
                </li>
                <li class="nav-mb-item">
                    <a href="shop-default.html" class="tf-category-link mb-menu-link">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate4.png')}}" alt="">
                        </div>
                        <span>Handbag</span>
                    </a>
                </li>
                <li class="nav-mb-item">
                    <a href="#cate-menu-one" class="tf-category-link has-children collapsed mb-menu-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="cate-menu-one">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate5.jpg')}}" alt="">
                        </div>
                        <span>Fashion</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="cate-menu-one" class="collapse list-cate">
                        <ul class="sub-nav-menu" id="cate-menu-navigation">
                            <li>
                                <a href="#cate-shop-one" class="tf-category-link has-children sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="cate-shop-one">
                                    <div class="image">
                                        <img src="{{asset('front/images/shop/cate/cate6.jpg')}}" alt="">
                                    </div>
                                    <span>Mens</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="cate-shop-one" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li>
                                            <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                                <div class="image">
                                                    <img src="{{asset('front/images/shop/cate/cate1.jpg')}}" alt="">
                                                </div>
                                                <span>Accessories</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                                <div class="image">
                                                    <img src="{{asset('front/images/shop/cate/cate8.jpg')}}" alt="">
                                                </div>
                                                <span>Shoes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#cate-shop-two" class="tf-category-link has-children sub-nav-link collapsed"  data-bs-toggle="collapse" aria-expanded="true" aria-controls="cate-shop-two">
                                    <div class="image">
                                        <img src="{{asset('front/images/shop/cate/cate9.jpg')}}" alt="">
                                    </div>
                                    <span>Womens</span>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="cate-shop-two" class="collapse">
                                    <ul class="sub-nav-menu sub-menu-level-2">
                                        <li>
                                            <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                                <div class="image">
                                                    <img src="{{asset('front/images/shop/cate/cate4.png')}}" alt="">
                                                </div>
                                                <span>Handbag</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                                <div class="image">
                                                    <img src="{{asset('front/images/shop/cate/cate7.jpg')}}" alt="">
                                                </div>
                                                <span>Tee</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-mb-item">
                    <a href="#cate-menu-two" class="tf-category-link has-children collapsed mb-menu-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="cate-menu-two">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate6.jpg')}}" alt="">
                        </div>
                        <span>Men</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="cate-menu-two" class="collapse list-cate">
                        <ul class="sub-nav-menu" id="cate-menu-navigation1">
                            <li>
                                <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                    <div class="image">
                                        <img src="{{asset('front/images/shop/cate/cate1.jpg')}}" alt="">
                                    </div>
                                    <span>Accessories</span>
                                </a>
                            </li>
                            <li>
                                <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                    <div class="image">
                                        <img src="{{asset('front/images/shop/cate/cate8.jpg')}}" alt="">
                                    </div>
                                    <span>Shoes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-mb-item">
                    <a href="shop-default.html" class="tf-category-link mb-menu-link">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate7.jpg')}}" alt="">
                        </div>
                        <span>Tee</span>
                    </a>
                </li>
                <li class="nav-mb-item">
                    <a href="shop-default.html" class="tf-category-link mb-menu-link">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate8.jpg')}}" alt="">
                        </div>
                        <span>Shoes</span>
                    </a>
                </li>
                <li class="nav-mb-item">
                    <a href="#cate-menu-three" class="tf-category-link has-children collapsed mb-menu-link" data-bs-toggle="collapse" aria-expanded="true" aria-controls="cate-menu-three">
                        <div class="image">
                            <img src="{{asset('front/images/shop/cate/cate9.jpg')}}" alt="">
                        </div>
                        <span>Women</span>
                        <span class="btn-open-sub"></span>
                    </a>
                    <div id="cate-menu-three" class="collapse list-cate">
                        <ul class="sub-nav-menu" id="cate-menu-navigation2">
                            <li>
                                <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                    <div class="image">
                                        <img src="{{asset('front/images/shop/cate/cate4.png')}}" alt="">
                                    </div>
                                    <span>Handbag</span>
                                </a>
                            </li>
                            <li>
                                <a href="shop-default.html" class="tf-category-link sub-nav-link">
                                    <div class="image">
                                        <img src="{{asset('front/images/shop/cate/cate7.jpg')}}" alt="">
                                    </div>
                                    <span>Tee</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="mb-bottom">
            <a href="shop-default.html" class="tf-btn fw-5 btn-line">View all collection<i class="icon icon-arrow1-top-left"></i></a>
        </div>
    </div>
</div>
<!-- /toolbarShopmb -->

<!-- modal login -->
<div class="modal modalCentered fade form-sign-in modal-part-content" id="login">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Giriş Yap</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="tf-login-form">
                <form class="" action="{{route('login')}}" accept-charset="utf-8" method="post">
                    @csrf
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="email"  name="email">
                        <label class="tf-field-label" for="">E-Posta *</label>
                    </div>
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="password"  name="password">
                        <label class="tf-field-label" for="">Şifre *</label>
                    </div>
                    <div>
                        <a href="#forgotPassword" data-bs-toggle="modal" class="btn-link link">Şifrenizi mi unuttunuz?</a>
                    </div>
                    <div class="bottom">
                        <div class="w-100">
                            <button type="submit" class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Giriş Yap</span></button>
                        </div>
                        <div class="w-100">
                            <a href="#register" data-bs-toggle="modal" class="btn-link fw-6 w-100 link">
                                Yeni müşteri misiniz? Hesabınızı oluşturun
                                <i class="icon icon-arrow1-top-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal modalCentered fade form-sign-in modal-part-content" id="forgotPassword">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Şifrenizi sıfırlayın</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="tf-login-form">
                <form class="" action="{{route('password.email')}}" method="post" accept-charset="utf-8" >
                    @csrf
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="email"  name="email">
                        <label class="tf-field-label" for="">E-Posta *</label>
                    </div>
                    <div>
                        <a href="#login" data-bs-toggle="modal" class="btn-link link">İptal</a>
                    </div>
                    <div class="bottom">
                        <div class="w-100">
                            <button type="submit" class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Şifreyi sıfırla</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal modalCentered fade form-sign-in modal-part-content" id="register">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Kayıt Ol</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="tf-login-form">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input @error('name') is-invalid @enderror"
                               placeholder=" "
                               type="text"
                               name="name"
                               value="{{ old('name') }}">
                        <label class="tf-field-label">Ad</label>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input @error('surname') is-invalid @enderror"
                               placeholder=" "
                               type="text"
                               name="surname"
                               value="{{ old('surname') }}">
                        <label class="tf-field-label">Soyad</label>
                        @error('surname')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input @error('email') is-invalid @enderror"
                               placeholder=" "
                               type="email"
                               name="email"
                               value="{{ old('email') }}">
                        <label class="tf-field-label">E-Posta *</label>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input @error('password') is-invalid @enderror"
                               placeholder=" "
                               type="password"
                               name="password">
                        <label class="tf-field-label">Şifre *</label>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bottom">
                        <div class="w-100">
                            <button type="submit"
                                    class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center">
                                <span>Kayıt Ol</span>
                            </button>
                        </div>
                        <div class="w-100">
                            <a href="#login" data-bs-toggle="modal" class="btn-link fw-6 w-100 link">
                                Zaten bir hesabınız var mı? Buradan giriş yapın
                                <i class="icon icon-arrow1-top-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /modal login -->

<!-- shoppingCart -->
@include('components.mini-cart')
<!-- /shoppingCart -->

<!-- modal quick_add -->
<div class="modal fade modalDemo" id="quick_add">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="wrap">
                <div class="tf-product-info-item">
                    <div class="image">
                        <img src="" alt="" id="quick-add-image">
                    </div>
                    <div class="content">
                        <a href="#" id="quick-add-name">Ürün Yükleniyor...</a>
                        <div class="tf-product-info-badges"></div>
                        <div class="tf-product-info-price price-container">
                            <span class="price" id="quick-add-price">0,00 ₺</span>
                        </div>
                    </div>
                </div>
                <div class="tf-product-info-variant-picker mb_15">
                    <!-- Varyantlar buraya dinamik yüklenecek -->
                </div>
                <div class="tf-product-info-quantity mb_15">
                    <div class="quantity-title fw-6">Miktar</div>
                    <div class="wg-quantity">
                        <span class="btn-quantity minus-btn">-</span>
                        <input type="text" name="number" value="1">
                        <span class="btn-quantity plus-btn">+</span>
                    </div>
                </div>
                <div class="tf-product-info-buy-button">
                    <form class="">
                        <a href="javascript:void(0);" class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart">
                            <span>Sepete Ekle -&nbsp;</span>
                            <span class="tf-qty-price" id="quick-add-total">0,00 ₺</span>
                        </a>
                        <div class="tf-product-btn-wishlist btn-icon-action">
                            <i class="icon-heart"></i>
                            <i class="icon-delete"></i>
                        </div>
                        <div class="w-100">
                            <a href="javascript:void(0);" class="btns-full btn-buy-with-iyzico text-white">
                                <img src="{{asset('front/images/brand/iyzico-colored-bg.svg')}}" alt="iyzico" style="height: 20px;"> ile Öde
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /modal quick_add -->

<!-- modal quick_view -->
<div class="modal fade modalDemo popup-quickview" id="quick_view">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="wrap">
                <div class="tf-product-media-wrap">
                    <div dir="ltr" class="swiper tf-single-slide">
                        <div class="swiper-wrapper">
                        </div>
                        <div class="swiper-button-next button-style-arrow single-slide-prev"></div>
                        <div class="swiper-button-prev button-style-arrow single-slide-next"></div>
                    </div>
                </div>

                <div class="tf-product-info-wrap position-relative">
                    <div class="tf-product-info-list">
                        <div class="tf-product-info-title">
                            <h5><a class="link" href="javascript:void(0);"></a></h5>
                        </div>

                        <div class="tf-product-info-badges">
                        </div>

                        <div class="tf-product-info-price price-container">
                        </div>

                        <div class="tf-product-description">
                            <p></p>
                        </div>

                        <div class="tf-product-info-variant-picker">
                        </div>

                        <div class="tf-product-info-quantity">
                            <div class="quantity-title fw-6">Miktar</div> <div class="wg-quantity">
                                <span class="btn-quantity minus-btn">-</span>
                                <input type="text" name="number" value="1">
                                <span class="btn-quantity plus-btn">+</span>
                            </div>
                        </div>

                        <div class="tf-product-info-buy-button">
                            <form class="">
                                <a href="javascript:void(0);" class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart">
                                    <span>Sepete Ekle - &nbsp;</span>
                                    <span class="tf-qty-price"></span>
                                </a>

                                <a href="javascript:void(0);" class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                                    <span class="icon icon-heart"></span>
                                    <span class="tooltip">Favorilere Ekle</span>
                                    <span class="icon icon-delete"></span>
                                </a>
                                <div class="w-100">
                                    <a href="javascript:void(0);" class="btns-full btn-buy-with-iyzico text-white">
                                        <img src="{{asset('front/images/brand/iyzico-colored-bg.svg')}}" alt="iyzico" style="height: 20px;"> ile Öde
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div>
                            <a href="javascript:void(0);" class="tf-btn fw-6 btn-line btn-view-full-details">
                                Tam detayları gör<i class="icon icon-arrow1-top-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /modal quick_view -->

<!-- modal find_size -->
<div class="modal fade modalDemo tf-product-modal" id="find_size">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Size chart</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="tf-rte">
                <div class="tf-table-res-df">
                    <h6>Size guide</h6>
                    <table class="tf-sizeguide-table">
                        <thead>
                        <tr>
                            <th>Size</th>
                            <th>US</th>
                            <th>Bust</th>
                            <th>Waist</th>
                            <th>Low Hip</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>XS</td>
                            <td>2</td>
                            <td>32</td>
                            <td>24 - 25</td>
                            <td>33 - 34</td>
                        </tr>
                        <tr>
                            <td>S</td>
                            <td>4</td>
                            <td>34 - 35</td>
                            <td>26 - 27</td>
                            <td>35 - 26</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>6</td>
                            <td>36 - 37</td>
                            <td>28 - 29</td>
                            <td>38 - 40</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>8</td>
                            <td>38 - 29</td>
                            <td>30 - 31</td>
                            <td>42 - 44</td>
                        </tr>
                        <tr>
                            <td>XL</td>
                            <td>10</td>
                            <td>40 - 41</td>
                            <td>32 - 33</td>
                            <td>45 - 47</td>
                        </tr>
                        <tr>
                            <td>XXL</td>
                            <td>12</td>
                            <td>42 - 43</td>
                            <td>34 - 35</td>
                            <td>48 - 50</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tf-page-size-chart-content">
                    <div>
                        <h6>Measuring Tips</h6>
                        <div class="title">Bust</div>
                        <p>Measure around the fullest part of your bust.</p>
                        <div class="title">Waist</div>
                        <p>Measure around the narrowest part of your torso.</p>
                        <div class="title">Low Hip</div>
                        <p class="mb-0">With your feet together measure around the fullest part of your hips/rear.
                        </p>
                    </div>
                    <div>
                        <img class="sizechart lazyload" data-src="{{asset('front/images/shop/products/size_chart2.jpg')}}" src="{{asset('front/images/shop/products/size_chart2.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /modal find_size -->

<!-- Javascript -->
<script type="text/javascript" src="{{asset('front/js/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="{{asset('front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/swiper-bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/carousel.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/lazysize.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/count-down.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/multiple-modal.js')}}"></script>
<script type="text/javascript" src="{{asset('front/js/main.js')}}"></script>

<!-- Axios Defaults -->
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
    axios.defaults.headers.common['Accept'] = 'application/json';
    axios.defaults.headers.common['Content-Type'] = 'application/json';
</script>

<!-- Global Toast System -->
<style>
    @keyframes toastSlideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes toastSlideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 8px;
        z-index: 99999;
        animation: toastSlideIn 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        font-weight: 500;
    }
    .toast-notification.toast-success {
        background: #28a745;
    }
    .toast-notification.toast-error {
        background: #dc3545;
    }
    .toast-notification.toast-warning {
        background: #ffc107;
        color: #333;
    }
    .toast-notification.toast-info {
        background: #17a2b8;
    }
    .toast-notification .toast-close {
        margin-left: 10px;
        cursor: pointer;
        opacity: 0.7;
    }
    .toast-notification .toast-close:hover {
        opacity: 1;
    }
</style>

<script>
    // Global Toast Function
    window.showToast = function(message, type = 'success', duration = 3000) {
        const iconMap = {
            success: 'icon-check',
            error: 'icon-close',
            warning: 'icon-notify',
            info: 'icon-help'
        };

        const $toast = $(`
            <div class="toast-notification toast-${type}">
                <i class="icon ${iconMap[type] || 'icon-check'}"></i>
                <span>${message}</span>
                <span class="toast-close">&times;</span>
            </div>
        `);

        $('body').append($toast);

        $toast.find('.toast-close').on('click', function() {
            $toast.css('animation', 'toastSlideOut 0.3s ease');
            setTimeout(() => $toast.remove(), 300);
        });

        setTimeout(() => {
            $toast.css('animation', 'toastSlideOut 0.3s ease');
            setTimeout(() => $toast.remove(), 300);
        }, duration);
    };

    // Show toast from session flash messages
    $(document).ready(function() {
        @if(session('toast_success'))
            showToast('{{ session('toast_success') }}', 'success');
        @endif
        @if(session('toast_error'))
            showToast('{{ session('toast_error') }}', 'error');
        @endif
        @if(session('toast_warning'))
            showToast('{{ session('toast_warning') }}', 'warning');
        @endif
        @if(session('toast_info'))
            showToast('{{ session('toast_info') }}', 'info');
        @endif
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.querySelector('#accountDropdownWrapper');
        if (!dropdown) return;

        const menu = dropdown.querySelector('.dropdown-menu');

        dropdown.addEventListener('mouseenter', function () {
            const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(dropdown.querySelector('[data-bs-toggle="dropdown"]'));
            dropdownInstance.show();
        });

        dropdown.addEventListener('mouseleave', function () {
            const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(dropdown.querySelector('[data-bs-toggle="dropdown"]'));
            dropdownInstance.hide();
        });
    });
</script>
@stack('scripts')
</body>

</html>
