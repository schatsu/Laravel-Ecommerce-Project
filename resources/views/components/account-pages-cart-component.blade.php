<!-- page-cart -->
<div class="col-lg-3">
    <div class="wrap-sidebar-account">
        <ul class="my-account-nav">
            <li><a href="{{route('account.index')}}" class="my-account-nav-item {{request()->routeIs('account.index') ? 'active' : ''}}">Hesabım</a></li>
            <li><a href="my-account-orders.html" class="my-account-nav-item">Siparişlerim</a></li>
            <li><a href="{{route('account.address')}}" class="my-account-nav-item {{request()->routeIs('account.address') ? 'active' : ''}}">Adreslerim</a></li>
            <li><a href="{{route('account.account.details')}}" class="my-account-nav-item {{request()->routeIs('account.account.details') ? 'active' : ''}}">Hesap Detaylarım</a></li>
            <li><a href="{{route('account.favorite.index')}}" class="my-account-nav-item {{request()->routeIs('account.favorites.index') ? 'active' : ''}}">İstek Listesi</a></li>
            <li><a href="{{route('logout')}}" class="my-account-nav-item">Çıkış Yap</a></li>
        </ul>
    </div>
</div>
<!-- page-cart -->

