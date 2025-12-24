<div class="modal fullRight fade modal-shopping-cart" id="shoppingCart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="header">
                <div class="title fw-5">Sepetiniz</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="wrap">
                <div class="tf-mini-cart-loading text-center py-5" id="mini-cart-loading">
                    <div class="spinner-border text-secondary" role="status">
                        <span class="visually-hidden">Yükleniyor...</span>
                    </div>
                </div>

                <div class="tf-mini-cart-empty text-center py-5 d-none" id="mini-cart-empty">
                    <i class="icon icon-bag" style="font-size: 60px; color: #ccc;"></i>
                    <p class="mt-3 mb-4 text-secondary">Sepetiniz boş</p>
                    <a href="{{ route('category.index') }}" class="tf-btn btn-fill animate-hover-btn radius-3"
                       data-bs-dismiss="modal">
                        <span>Alışverişe Başla</span>
                    </a>
                </div>

                <div class="tf-mini-cart-content d-none" id="mini-cart-content">
                    <div class="tf-mini-cart-threshold">
                        <div class="tf-progress-bar">
                            <span id="mini-cart-progress" style="width: 0%;">
                                <div class="progress-car">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="14" viewBox="0 0 21 14"
                                         fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M0 0.875C0 0.391751 0.391751 0 0.875 0H13.5625C14.0457 0 14.4375 0.391751 14.4375 0.875V3.0625H17.3125C17.5867 3.0625 17.845 3.19101 18.0104 3.40969L20.8229 7.12844C20.9378 7.2804 21 7.46572 21 7.65625V11.375C21 11.8582 20.6082 12.25 20.125 12.25H17.7881C17.4278 13.2695 16.4554 14 15.3125 14C14.1696 14 13.1972 13.2695 12.8369 12.25H7.72563C7.36527 13.2695 6.39293 14 5.25 14C4.10706 14 3.13473 13.2695 2.77437 12.25H0.875C0.391751 12.25 0 11.8582 0 11.375V0.875ZM2.77437 10.5C3.13473 9.48047 4.10706 8.75 5.25 8.75C6.39293 8.75 7.36527 9.48046 7.72563 10.5H12.6875V1.75H1.75V10.5H2.77437ZM14.4375 8.89937V4.8125H16.8772L19.25 7.94987V10.5H17.7881C17.4278 9.48046 16.4554 8.75 15.3125 8.75C15.0057 8.75 14.7112 8.80264 14.4375 8.89937ZM5.25 10.5C4.76676 10.5 4.375 10.8918 4.375 11.375C4.375 11.8582 4.76676 12.25 5.25 12.25C5.73323 12.25 6.125 11.8582 6.125 11.375C6.125 10.8918 5.73323 10.5 5.25 10.5ZM15.3125 10.5C14.8293 10.5 14.4375 10.8918 14.4375 11.375C14.4375 11.8582 14.8293 12.25 15.3125 12.25C15.7957 12.25 16.1875 11.8582 16.1875 11.375C16.1875 10.8918 15.7957 10.5 15.3125 10.5Z"></path>
                                    </svg>
                                </div>
                            </span>
                        </div>
                        <div class="tf-progress-msg" id="mini-cart-progress-msg">
                            Ücretsiz Kargodan yararlanmak için <span class="price fw-6">500₺</span> ve üzeri <span
                                class="fw-6">Alışveriş yapın</span>
                        </div>
                    </div>
                    <div class="tf-mini-cart-wrap">
                        <div class="tf-mini-cart-main">
                            <div class="tf-mini-cart-sroll">
                                <div class="tf-mini-cart-items" id="mini-cart-items">
                                </div>
                            </div>
                        </div>
                        <div class="tf-mini-cart-bottom">
                            <div class="tf-mini-cart-bottom-wrap">
                                <div class="tf-cart-totals-discounts">
                                    <div class="tf-cart-total">Ara Toplam</div>
                                    <div class="tf-totals-total-value fw-6" id="mini-cart-subtotal">0,00₺</div>
                                </div>
                                <div class="tf-cart-tax">Vergiler ve <a href="#">kargo</a> ödeme sırasında hesaplanır
                                </div>
                                <div class="tf-mini-cart-line"></div>
                                <div class="tf-mini-cart-view-checkout">
                                    <a href="{{ route('cart.index') }}"
                                       class="tf-btn btn-outline radius-3 link w-100 justify-content-center">Sepeti
                                        Görüntüle</a>
                                    <a href="{{route('checkout.index')}}"
                                       class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Ödemeye Geç</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        $(document).ready(() => {
            const FREE_SHIPPING_THRESHOLD = 500;

            const loadMiniCart = async () => {
                const $loading = $('#mini-cart-loading');
                const $empty = $('#mini-cart-empty');
                const $content = $('#mini-cart-content');

                $loading.removeClass('d-none');
                $empty.addClass('d-none');
                $content.addClass('d-none');

                try {
                    const response = await axios.get('{{ route("cart.show") }}');
                    const cart = response.data.data;

                    $loading.addClass('d-none');

                    if (cart.is_empty) {
                        $empty.removeClass('d-none');
                        $content.addClass('d-none');
                        return;
                    }

                    $empty.addClass('d-none');
                    $content.removeClass('d-none');

                    renderMiniCartItems(cart.items);
                    updateMiniCartTotals(cart.subtotal);
                    updateHeaderCartCount(cart.count);

                } catch (error) {
                    console.error('Mini cart load error:', error);
                    $loading.addClass('d-none');
                }
            };

            const renderMiniCartItems = (items) => {
                const $container = $('#mini-cart-items');

                if (!items || items.length === 0) {
                    $container.html('');
                    return;
                }

                const html = items.map(item => `
            <div class="tf-mini-cart-item" data-item-id="${item.id}">
                <div class="tf-mini-cart-image">
                    <a href="${item.product_url}">
                        <img src="${item.image || '/front/images/default.jpg'}" alt="${item.name}">
                    </a>
                </div>
                <div class="tf-mini-cart-info">
                    <a class="title link" href="${item.product_url}">${item.name}</a>
                    ${item.variant ? `<div class="meta-variant">${item.variant}</div>` : ''}
                    <div class="price fw-6">${item.unit_price}₺</div>
                    <div class="tf-mini-cart-btns">
                        <div class="wg-quantity small">
                            <span class="btn-quantity minus-btn" data-item-id="${item.id}">-</span>
                            <input type="text" value="${item.quantity}" readonly>
                            <span class="btn-quantity plus-btn" data-item-id="${item.id}">+</span>
                        </div>
                        <div class="tf-mini-cart-remove" data-item-id="${item.id}">Kaldır</div>
                    </div>
                </div>
            </div>
        `).join('');

                $container.html(html);

                $container.off('click', '.minus-btn').on('click', '.minus-btn', e =>
                    updateMiniCartItem($(e.currentTarget).data('item-id'), -1)
                );

                $container.off('click', '.plus-btn').on('click', '.plus-btn', e =>
                    updateMiniCartItem($(e.currentTarget).data('item-id'), 1)
                );

                $container.off('click', '.tf-mini-cart-remove').on('click', '.tf-mini-cart-remove', e =>
                    removeMiniCartItem($(e.currentTarget).data('item-id'))
                );
            };

            const updateMiniCartItem = async (itemId, delta) => {
                const $item = $(`.tf-mini-cart-item[data-item-id="${itemId}"]`);
                const $input = $item.find('input');
                const newQty = parseInt($input.val(), 10) + delta;

                if (newQty < 1) {
                    await removeMiniCartItem(itemId);
                    return;
                }

                try {
                    const response = await axios.patch(
                        '{{ route("cart.update", ["item" => "__ITEM_ID__"]) }}'.replace('__ITEM_ID__', itemId),
                        { quantity: newQty }
                    );

                    if (!response.data.success) return;

                    $input.val(newQty);
                    updateMiniCartTotals(response.data.data.cart_subtotal);
                    updateHeaderCartCount(response.data.data.cart_count);

                } catch (error) {
                    console.error('Update error:', error);
                }
            };

            const removeMiniCartItem = async (itemId) => {
                try {
                    const response = await axios.delete(
                        '{{ route("cart.destroy", ["item" => "__ITEM_ID__"]) }}'.replace('__ITEM_ID__', itemId)
                    );

                    if (!response.data.success) return;

                    $(`.tf-mini-cart-item[data-item-id="${itemId}"]`).remove();
                    updateMiniCartTotals(response.data.data.cart_subtotal);
                    updateHeaderCartCount(response.data.data.cart_count);

                    if (response.data.data.cart_count === 0) {
                        $('#mini-cart-empty').removeClass('d-none');
                        $('#mini-cart-content').addClass('d-none');
                    }

                } catch (error) {
                    console.error('Remove error:', error);
                }
            };

            const updateMiniCartTotals = (subtotal) => {
                $('#mini-cart-subtotal').text(`${subtotal}₺`);

                const subtotalNum = parseFloat(subtotal.replace('.', '').replace(',', '.'));
                const progress = Math.min((subtotalNum / FREE_SHIPPING_THRESHOLD) * 100, 100);

                $('#mini-cart-progress').css('width', `${progress}%`);

                const $msg = $('#mini-cart-progress-msg');

                if (subtotalNum >= FREE_SHIPPING_THRESHOLD) {
                    $msg.html('<span class="fw-6 text-success">🎉 Ücretsiz Kargo Kazandınız!</span>');
                } else {
                    const remaining = (FREE_SHIPPING_THRESHOLD - subtotalNum)
                        .toFixed(2)
                        .replace('.', ',');

                    $msg.html(`
                Ücretsiz Kargodan yararlanmak için
                <span class="price fw-6">${remaining}₺</span> ve üzeri
                <span class="fw-6">Alışveriş yapın</span>
            `);
                }
            };

            const updateHeaderCartCount = async (count) => {
                if (count !== undefined) {
                    $('.count-box, .toolbar-count, .cart-count').text(count);
                    return;
                }

                try {
                    const response = await axios.get('{{ route("cart.show") }}');
                    $('.count-box, .toolbar-count, .cart-count').text(response.data.data.count);
                } catch (error) {
                    console.error('Header cart error:', error);
                }
            };


            $('#shoppingCart').on('show.bs.modal', () => {
                loadMiniCart();
            });


            updateHeaderCartCount();

            window.refreshMiniCart = loadMiniCart;
            window.updateHeaderCartCount = updateHeaderCartCount;
        });
    </script>
@endpush

