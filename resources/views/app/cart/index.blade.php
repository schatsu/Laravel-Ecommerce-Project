@extends('app.layouts.main')
@section('title', 'Sepetim')

@section('content')
    <div class="tf-page-title">
        <div class="container-full">
            <div class="heading text-center">Sepetim</div>
        </div>
    </div>

    <section class="flat-spacing-11">
        <div class="container">
            @if($cart->is_empty)
                <div class="tf-page-cart text-center mt_140 mb_200">
                    <h5 class="mb_24">Sepetiniz Boş</h5>
                    <p class="mb_24">Sepetinizde henüz ürün bulunmuyor. Alışverişe başlamak için aşağıdaki butona tıklayın.</p>
                    <a href="{{ route('category.index') }}" class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">
                        Alışverişe Başla<i class="icon icon-arrow1-top-left"></i>
                    </a>
                </div>
            @else
                <div class="tf-page-cart-wrap">
                    <div class="tf-page-cart-item">
                        <table class="tf-table-page-cart">
                            <thead>
                                <tr>
                                    <th>Ürün</th>
                                    <th>Fiyat</th>
                                    <th>Miktar</th>
                                    <th>Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr class="tf-cart-item file-delete" data-item-id="{{ $item->id }}">
                                        <td class="tf-cart-item_product">
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="img-box">
                                                <img src="{{ $item->image_url ?: asset('front/images/default.jpg') }}"
                                                     alt="{{ $item->product->name }}">
                                            </a>
                                            <div class="cart-info">
                                                <a href="{{ route('product.show', $item->product->slug) }}" class="cart-title link">
                                                    {{ $item->product->name }}
                                                </a>
                                                @if($item->variation)
                                                    <div class="cart-meta-variant">
                                                        @foreach($item->variation->selectedOptions() as $option)
                                                            {{ $option->name }}@if(!$loop->last) / @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <span class="remove-cart link remove" data-item-id="{{ $item->id }}">Kaldır</span>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_price" cart-data-title="Fiyat">
                                            <div class="cart-price price">{{ number_format($item->unit_price, 2, ',', '.') }}₺</div>
                                        </td>
                                        <td class="tf-cart-item_quantity" cart-data-title="Miktar">
                                            <div class="cart-quantity">
                                                <div class="wg-quantity">
                                                    <span class="btn-quantity btndecrease" data-item-id="{{ $item->id }}">
                                                        <svg class="d-inline-block" width="9" height="1" viewBox="0 0 9 1" fill="currentColor">
                                                            <path d="M9 1H5.14286H3.85714H0V1.50201e-05H3.85714L5.14286 0L9 1.50201e-05V1Z"></path>
                                                        </svg>
                                                    </span>
                                                    <input type="text" name="number" value="{{ $item->quantity }}" class="quantity-input">
                                                    <span class="btn-quantity btnincrease" data-item-id="{{ $item->id }}">
                                                        <svg class="d-inline-block" width="9" height="9" viewBox="0 0 9 9" fill="currentColor">
                                                            <path d="M9 5.14286H5.14286V9H3.85714V5.14286H0V3.85714H3.85714V0H5.14286V3.85714H9V5.14286Z"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tf-cart-item_total" cart-data-title="Toplam">
                                            <div class="cart-total price item-total">{{ number_format($item->total, 2, ',', '.') }}₺</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tf-page-cart-footer">
                        <div class="tf-cart-footer-inner">
                            <div class="tf-free-shipping-bar">
                                <div class="tf-progress-bar">
                                    @php
                                        $freeShippingThreshold = 500;
                                        $progress = min(($cart->subtotal / $freeShippingThreshold) * 100, 100);
                                        $remaining = max($freeShippingThreshold - $cart->subtotal, 0);
                                    @endphp
                                    <span style="width: {{ $progress }}%;">
                                        <div class="progress-car">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="14" viewBox="0 0 21 14" fill="currentColor">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.875C0 0.391751 0.391751 0 0.875 0H13.5625C14.0457 0 14.4375 0.391751 14.4375 0.875V3.0625H17.3125C17.5867 3.0625 17.845 3.19101 18.0104 3.40969L20.8229 7.12844C20.9378 7.2804 21 7.46572 21 7.65625V11.375C21 11.8582 20.6082 12.25 20.125 12.25H17.7881C17.4278 13.2695 16.4554 14 15.3125 14C14.1696 14 13.1972 13.2695 12.8369 12.25H7.72563C7.36527 13.2695 6.39293 14 5.25 14C4.10706 14 3.13473 13.2695 2.77437 12.25H0.875C0.391751 12.25 0 11.8582 0 11.375V0.875ZM2.77437 10.5C3.13473 9.48047 4.10706 8.75 5.25 8.75C6.39293 8.75 7.36527 9.48046 7.72563 10.5H12.6875V1.75H1.75V10.5H2.77437ZM14.4375 8.89937V4.8125H16.8772L19.25 7.94987V10.5H17.7881C17.4278 9.48046 16.4554 8.75 15.3125 8.75C15.0057 8.75 14.7112 8.80264 14.4375 8.89937ZM5.25 10.5C4.76676 10.5 4.375 10.8918 4.375 11.375C4.375 11.8582 4.76676 12.25 5.25 12.25C5.73323 12.25 6.125 11.8582 6.125 11.375C6.125 10.8918 5.73323 10.5 5.25 10.5ZM15.3125 10.5C14.8293 10.5 14.4375 10.8918 14.4375 11.375C14.4375 11.8582 14.8293 12.25 15.3125 12.25C15.7957 12.25 16.1875 11.8582 16.1875 11.375C16.1875 10.8918 15.7957 10.5 15.3125 10.5Z"></path>
                                            </svg>
                                        </div>
                                    </span>
                                </div>
                                <div class="tf-progress-msg">
                                    @if($remaining > 0)
                                        Ücretsiz Kargo için <span class="price fw-6">{{ number_format($remaining, 2, ',', '.') }}₺</span> daha ekleyin
                                    @else
                                        <span class="fw-6 text-success">Ücretsiz Kargo Kazandınız!</span>
                                    @endif
                                </div>
                            </div>
                            <div class="tf-page-cart-checkout">
                                <div class="tf-cart-totals-discounts">
                                    <h3>Ara Toplam</h3>
                                    <span class="total-value cart-subtotal-value">{{ number_format($cart->subtotal, 2, ',', '.') }}₺</span>
                                </div>
                                <p class="tf-cart-tax">
                                    Kargo ücreti ödeme sayfasında hesaplanacaktır
                                </p>
                                <div class="cart-checkout-btn">
                                    <a href="{{route('checkout.index')}}" class="tf-btn w-100 btn-fill animate-hover-btn radius-3 justify-content-center">
                                        <span>Ödemeye Geç</span>
                                    </a>
                                </div>
                                <div class="tf-page-cart_imgtrust">
                                    <p class="text-center fw-6">Güvenli Ödeme</p>
                                    <div class="cart-list-social">
                                        <div class="payment-item">
                                            <img src="{{ asset('front/images/payments/visa.png') }}" alt="Visa">
                                        </div>
                                        <div class="payment-item">
                                            <img src="{{ asset('front/images/payments/mastercard.png') }}" alt="Mastercard">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
$(document).ready(() => {
    const FREE_SHIPPING_THRESHOLD = 500;
    const rowLocks = new Set();

    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        $('meta[name="csrf-token"]').attr('content');
    axios.defaults.headers.common['Accept'] = 'application/json';

    const normalizePrice = (price) => {
        if (typeof price === 'number') return price;
        return parseFloat(price.replace('.', '').replace(',', '.'));
    };

    const formatPrice = (price) =>
        normalizePrice(price).toLocaleString('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + '₺';


    const updateSubtotal = (subtotal) => {
        $('.cart-subtotal-value, .total-value').text(formatPrice(subtotal));
    };

    const updateCartCount = (count) => {
        $('.count-box, .cart-count, .toolbar-count').text(count);
    };

    const updateShippingProgress = (subtotal) => {
        const subtotalNum = normalizePrice(subtotal);
        const progress = Math.min((subtotalNum / FREE_SHIPPING_THRESHOLD) * 100, 100);

        $('.tf-free-shipping-bar .tf-progress-bar span')
            .css('width', `${progress}%`);

        const $msg = $('.tf-free-shipping-bar .tf-progress-msg');

        if (subtotalNum >= FREE_SHIPPING_THRESHOLD) {
            $msg.html('<span class="fw-6 text-success">Ücretsiz Kargo Kazandınız!</span>');
        } else {
            const remaining = FREE_SHIPPING_THRESHOLD - subtotalNum;
            $msg.html(
                `Ücretsiz Kargo için <span class="price fw-6">${formatPrice(remaining)}</span> daha ekleyin`
            );
        }
    };

    const toast = (message, type = 'success') => {
        if (window.showToast) {
            window.showToast(message, type);
        }
    };



    const updateCartItem = async (itemId, quantity, $row) => {
        if (rowLocks.has(itemId)) return;
        rowLocks.add(itemId);

        try {
            const url = '{{ route("cart.update", ["item" => "__ITEM_ID__"]) }}'
                .replace('__ITEM_ID__', itemId);

            const response = await axios.patch(url, { quantity });

            if (!response.data.success) {
                toast(response.data.message || 'Bir hata oluştu', 'error');
                return;
            }

            $row.find('.quantity-input').val(quantity);
            $row.find('.item-total').text(formatPrice(response.data.data.item_total));

            updateSubtotal(response.data.data.cart_subtotal);
            updateCartCount(response.data.data.cart_count);
            updateShippingProgress(response.data.data.cart_subtotal);

        } catch (error) {
            console.error(error);
            toast(error.response?.data?.message || 'Bir hata oluştu', 'error');
        } finally {
            rowLocks.delete(itemId);
        }
    };

    const removeCartItem = async (itemId, $row) => {
        try {
            const url = '{{ route("cart.destroy", ["item" => "__ITEM_ID__"]) }}'
                .replace('__ITEM_ID__', itemId);

            const response = await axios.delete(url);

            if (!response.data.success) {
                toast(response.data.message || 'Bir hata oluştu', 'error');
                return;
            }

            const resData = response.data.data;

            $row.fadeOut(250, () => {
                $row.remove();
                if (resData.cart_count === 0) location.reload();
            });

            updateSubtotal(resData.cart_subtotal);
            updateCartCount(resData.cart_count);
            updateShippingProgress(resData.cart_subtotal);

            toast(response.data.message || 'Ürün sepetten kaldırıldı', 'success');

        } catch (error) {
            console.error(error);
            toast(error.response?.data?.message || 'Bir hata oluştu', 'error');
        }
    };

    $(document).on('click', '.remove-cart', function (e) {
        e.preventDefault();
        console.log('Remove clicked', $(this).data('item-id'));
        const $row = $(this).closest('.tf-cart-item');
        const itemId = $(this).data('item-id');
        if (confirm('Bu ürünü sepetten kaldırmak istediğinize emin misiniz?')) {
            removeCartItem(itemId, $row);
        }
    });

    $(document).on('click', '.btnincrease', function () {
        const $row = $(this).closest('.tf-cart-item');
        const itemId = $(this).data('item-id');
        const qty = parseInt($row.find('.quantity-input').val(), 10) || 1;
        updateCartItem(itemId, qty + 1, $row);
    });

    $(document).on('click', '.btndecrease', function () {
        const $row = $(this).closest('.tf-cart-item');
        const itemId = $(this).data('item-id');
        const qty = parseInt($row.find('.quantity-input').val(), 10) || 1;
        if (qty > 1) updateCartItem(itemId, qty - 1, $row);
    });
});
</script>
@endpush
