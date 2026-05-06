<?php
defined('ABSPATH') || exit;
get_header('shop');

global $product;
$product = wc_get_product(get_the_ID());
if (!$product)
    return;
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('bg-white font-sans', $product); ?>>

    <div class="py-3 px-6 md:px-10 max-w-7xl mt-[60px] mx-auto">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span>/</span>
            <span class="text-gray-900"><?php the_title(); ?></span>
        </nav>
    </div>

    <section class="pb-16">
        <div class="mx-auto max-w-7xl px-6 md:px-10">
            <div class="grid gap-8 lg:grid-cols-12 items-start">

                <div class="lg:col-span-7 flex flex-col md:flex-row gap-4">
                    <?php
                    $attachment_ids = $product->get_gallery_image_ids();
                    $main_image_id = $product->get_image_id();
                    $gallery_images = array();

                    if ( $main_image_id ) {
                        $gallery_images[] = array(
                            'id'    => $main_image_id,
                            'thumb' => wp_get_attachment_image_url( $main_image_id, 'thumbnail' ),
                            'full'  => wp_get_attachment_image_url( $main_image_id, 'full' ),
                        );
                    }

                    foreach ( $attachment_ids as $attachment_id ) {
                        $gallery_images[] = array(
                            'id'    => $attachment_id,
                            'thumb' => wp_get_attachment_image_url( $attachment_id, 'thumbnail' ),
                            'full'  => wp_get_attachment_image_url( $attachment_id, 'full' ),
                        );
                    }

                    $primary_image = ! empty( $gallery_images[0] ) ? $gallery_images[0] : array( 'thumb' => '', 'full' => '' );
                    ?>

                    <div class="hidden md:flex flex-col gap-3 w-20">
                        <?php foreach ( $gallery_images as $index => $image ) : ?>
                            <?php if ( empty( $image['thumb'] ) || empty( $image['full'] ) ) { continue; } ?>
                            <button
                                type="button"
                                class="gallery-thumb cursor-pointer rounded-lg border <?php echo 0 === $index ? 'border-orange-500 ring-2 ring-orange-200' : 'border-gray-100'; ?> overflow-hidden hover:border-orange-500 transition product-image-clickable"
                                data-full="<?php echo esc_url( $image['full'] ); ?>"
                                data-thumb="<?php echo esc_url( $image['thumb'] ); ?>"
                                onclick="selectProductImage(this)">
                                <img src="<?php echo esc_url( $image['thumb'] ); ?>" class="w-full aspect-square object-cover" alt="<?php echo esc_attr( get_the_title() ); ?>">
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex-1">
                        <div class="rounded-2xl border border-gray-50 overflow-hidden shadow-sm product-image-clickable">
                            <img id="shopker-product-main-image"
                                src="<?php echo esc_url( $primary_image['full'] ); ?>"
                                data-full="<?php echo esc_url( $primary_image['full'] ); ?>"
                                class="w-full h-auto"
                                alt="<?php echo esc_attr( get_the_title() ); ?>"
                                onclick="openCurrentProductImage()">
                        </div>
                        <div class="flex md:hidden gap-2 mt-4 overflow-x-auto">
                            <?php foreach ( $gallery_images as $index => $image ) : ?>
                                <?php if ( empty( $image['thumb'] ) || empty( $image['full'] ) ) { continue; } ?>
                                <button
                                    type="button"
                                    class="gallery-thumb product-image-clickable <?php echo 0 === $index ? 'ring-2 ring-orange-500' : ''; ?>"
                                    data-full="<?php echo esc_url( $image['full'] ); ?>"
                                    data-thumb="<?php echo esc_url( $image['thumb'] ); ?>"
                                    onclick="selectProductImage(this)">
                                    <img src="<?php echo esc_url( $image['thumb'] ); ?>"
                                        class="w-16 h-16 rounded-lg object-cover border">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 lg:sticky lg:top-10">
                    <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight mb-2">
                        <?php the_title(); ?>
                    </h1>

                    <div class="mb-6 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1">
                                <span class="text-[#FFB800] text-lg">⭐⭐⭐⭐⭐</span>
                                <span class="text-sm font-black text-gray-900">Trustscore 4.9</span>
                            </div>
                            <div class="h-4 w-px bg-gray-300"></div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">3378+ reviews</span>
                        </div>

                        <div
                            class="inline-flex items-center gap-2 bg-green-50 px-4 py-2 rounded-xl border border-green-100 shadow-sm">
                            <span class="text-green-600 text-sm font-black uppercase italic flex items-center gap-2">
                                📈 <span id="live-sold-count">6,046</span> SOLD
                            </span>
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                        </div>
                    </div>

                    <?php echo function_exists( 'shopker_render_color_variant_badges' ) ? wp_kses_post( shopker_render_color_variant_badges( $product ) ) : ''; ?>

                    <div class="mb-8">
                        <p class="text-[11px] font-black uppercase tracking-widest text-gray-400 mb-3">Select Pack:</p>
                        <div class="flex flex-wrap gap-3" id="pack-selector">
                            <?php
                            $tiers = shopker_get_tier_pricing_data($product->get_id());
                            $tier_prices = array();
                            $base_price = floatval($product->get_price());

                            // Set Pack of 1 to base price (no tier discount)
                            $tier_prices[1] = $base_price;

                            // For pack of 2, use tier pricing if available, else apply basic discount (10%)
                            for ($qty = 2; $qty <= 2; $qty++) {
                                $tier_price = shopker_get_applicable_tier_price($qty, $tiers);

                                // If no tier pricing is set, apply a simple discount (10% for pack 2)
                                if ($tier_price <= 0 || $tier_price === $base_price) {
                                    $discount = 0.10;
                                    $tier_price = $base_price * $qty * (1 - $discount);
                                }

                                $tier_prices[$qty] = $tier_price;
                            }

                            for ($qty = 1; $qty <= 2; $qty++) {
                                $is_active = $qty === 1 ? 'active' : '';
                                ?>
                                <button type="button"
                                    class="pack-btn flex-1 px-4 py-3 rounded-xl font-black uppercase text-xs transition duration-200 border-2 <?php echo $qty === 1 ? 'border-[#1a1a1a] bg-[#1a1a1a] text-white' : 'border-gray-200 bg-white text-gray-900 hover:border-[#1a1a1a]'; ?>"
                                    data-pack="<?php echo $qty; ?>" data-price="<?php echo esc_attr($tier_prices[$qty]); ?>"
                                    onclick="selectPack(<?php echo $qty; ?>)">
                                    <div class="leading-none">
                                        <p class="mb-1">Pack of <?php echo $qty; ?><?php echo $qty === 2 ? ' <span class="text-orange-600">🎁 GET 1 FREE</span>' : ''; ?></p>
                                        <p class="text-[11px] font-bold">Rs.
                                            <?php echo number_format($tier_prices[$qty], 0); ?>
                                        </p>
                                    </div>
                                </button>
                            <?php } ?>
                        </div>

                        <script>
                            const tierPrices = <?php echo wp_json_encode($tier_prices); ?>;
                            let selectedPack = 1;

                            function selectPack(pack) {
                                selectedPack = pack;

                                // Update button styles
                                document.querySelectorAll('.pack-btn').forEach(btn => {
                                    if (parseInt(btn.dataset.pack) === pack) {
                                        btn.classList.remove('border-gray-200', 'bg-white', 'text-gray-900', 'hover:border-[#1a1a1a]');
                                        btn.classList.add('border-[#1a1a1a]', 'bg-[#1a1a1a]', 'text-white');
                                    } else {
                                        btn.classList.remove('border-[#1a1a1a]', 'bg-[#1a1a1a]', 'text-white');
                                        btn.classList.add('border-gray-200', 'bg-white', 'text-gray-900', 'hover:border-[#1a1a1a]');
                                    }
                                });

                                // Update price display
                                const priceDisplay = document.querySelector('.price-display-dynamic');
                                if (priceDisplay && tierPrices[pack]) {
                                    priceDisplay.textContent = 'Rs. ' + parseInt(tierPrices[pack]).toLocaleString('en-PK');
                                }

                                // Update quantity field in cart form
                                const quantityField = document.querySelector('input[name="quantity"]');
                                if (quantityField) {
                                    quantityField.value = pack;
                                }
                            }
                        </script>
                    </div>

                    <div class="text-3xl font-black text-orange-600 mb-6">
                        <span
                            class="price-display-dynamic"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-4">
                            <style>
                                /* The Main Button */
                                .woocommerce div.product form.cart .button.single_add_to_cart_button {
                                    background: linear-gradient(135deg, #FF4500 0%, #FF6B35 100%) !important;
                                    color: #ffffff !important;
                                    border-radius: 50px !important;
                                    padding: 18px 30px !important;
                                    font-size: 17px !important;
                                    font-weight: 900 !important;
                                    text-transform: uppercase !important;
                                    letter-spacing: 2px !important;
                                    border: none !important;
                                    width: 100% !important;
                                    cursor: pointer !important;
                                    position: relative !important;
                                    overflow: hidden !important;
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    gap: 10px !important;

                                    /* The 3-second rocking cycle */
                                    animation: shopker-rocking-shake 3s infinite;
                                    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                                    box-shadow: 0 8px 25px rgba(255, 69, 0, 0.5);
                                    min-height: 56px !important;
                                }

                                /* Shimmer effect on button */
                                .woocommerce div.product form.cart .button.single_add_to_cart_button::after {
                                    content: '';
                                    position: absolute;
                                    top: -50%;
                                    left: -50%;
                                    width: 200%;
                                    height: 200%;
                                    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
                                    animation: shopker-shimmer 3s infinite;
                                }

                                @keyframes shopker-shimmer {
                                    0% {
                                        transform: translateX(-100%) translateY(-100%);
                                    }
                                    100% {
                                        transform: translateX(100%) translateY(100%);
                                    }
                                }

                                /* Rocking Animation Keyframes */
                                @keyframes shopker-rocking-shake {
                                    0%,
                                    80% {
                                        transform: rotate(0deg) scale(1);
                                    }

                                    82% {
                                        transform: rotate(3deg) scale(1.01);
                                    }

                                    84% {
                                        transform: rotate(-3deg) scale(1.01);
                                    }

                                    86% {
                                        transform: rotate(3deg) scale(1.01);
                                    }

                                    88% {
                                        transform: rotate(-3deg) scale(1.01);
                                    }

                                    90% {
                                        transform: rotate(0deg) scale(1);
                                    }
                                }

                                /* Hover State */
                                .woocommerce div.product form.cart .button.single_add_to_cart_button:hover {
                                    background: linear-gradient(135deg, #e63e00 0%, #FF4500 100%) !important;
                                    animation: none !important;
                                    transform: scale(1.05) !important;
                                    box-shadow: 0 12px 35px rgba(255, 69, 0, 0.7) !important;
                                }

                                /* Active/Click State */
                                .woocommerce div.product form.cart .button.single_add_to_cart_button:active {
                                    transform: scale(0.98) !important;
                                    box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4) !important;
                                }

                                /* Loading state */
                                .woocommerce div.product form.cart .button.single_add_to_cart_button:disabled {
                                    opacity: 0.7 !important;
                                    cursor: not-allowed !important;
                                }

                                /* Button text styling */
                                .woocommerce div.product form.cart .button.single_add_to_cart_button span {
                                    position: relative;
                                    z-index: 1;
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                }

                                /* Buy Now Button (Black Contrast) */
                                .btn-buy-now {
                                    background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%) !important;
                                    color: #ffffff !important;
                                    border-radius: 12px !important;
                                    padding: 20px;
                                    font-size: 16px;
                                    font-weight: 900;
                                    text-transform: uppercase;
                                    width: 100%;
                                    text-align: center;
                                    display: block;
                                    margin-top: 10px;
                                    transition: 0.3s;
                                }

                                /* Quantity Selector Styles */
                                .quantity-selector {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    border: 2px solid #e0e0e0;
                                    border-radius: 8px;
                                    width: fit-content;
                                    margin-bottom: 1rem;
                                }

                                .qty-btn {
                                    width: 40px;
                                    height: 40px;
                                    border: none;
                                    background: white;
                                    font-size: 20px;
                                    font-weight: bold;
                                    cursor: pointer;
                                    transition: all 0.3s ease;
                                    color: #333;
                                }

                                .qty-btn:hover {
                                    background: #f5f5f5;
                                }

                                .qty-input {
                                    width: 50px;
                                    height: 40px;
                                    border: none;
                                    border-left: 2px solid #e0e0e0;
                                    border-right: 2px solid #e0e0e0;
                                    text-align: center;
                                    font-size: 16px;
                                    font-weight: bold;
                                    background: white;
                                }

                                .qty-input:focus {
                                    outline: none;
                                }

                                /* Custom Add to Cart Button */
                                .shopker-add-to-cart-btn {
                                    background: #ffffff !important;
                                    color: #00BCD4 !important;
                                    border: 2px solid #00BCD4 !important;
                                    border-radius: 8px !important;
                                    padding: 16px 24px !important;
                                    font-size: 14px !important;
                                    font-weight: 900 !important;
                                    text-transform: uppercase !important;
                                    letter-spacing: 1px !important;
                                    width: 100% !important;
                                    cursor: pointer !important;
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    gap: 10px !important;
                                    transition: all 0.3s ease !important;
                                    box-shadow: 0 4px 12px rgba(0, 188, 212, 0.2) !important;
                                    margin-bottom: 12px !important;
                                }

                                .shopker-add-to-cart-btn:hover {
                                    background: #f0f9fa !important;
                                    border-color: #00ACC1 !important;
                                    box-shadow: 0 6px 16px rgba(0, 188, 212, 0.3) !important;
                                    transform: translateY(-2px);
                                }

                                .shopker-add-to-cart-btn:active {
                                    transform: translateY(0);
                                }

                                .cart-price-display {
                                    color: #00BCD4 !important;
                                    font-weight: 900 !important;
                                    font-size: 13px !important;
                                }

                                .price-amount {
                                    color: #00BCD4 !important;
                                    font-weight: 900 !important;
                                }

                                /* Order Now Button */
                                .shopker-order-now-btn {
                                    background: linear-gradient(135deg, #FF4500 0%, #FF6B35 100%) !important;
                                    color: #ffffff !important;
                                    border: none !important;
                                    border-radius: 50px !important;
                                    padding: 14px 20px !important;
                                    font-size: 13px !important;
                                    font-weight: 900 !important;
                                    text-transform: uppercase !important;
                                    letter-spacing: 0.5px !important;
                                    width: 100% !important;
                                    cursor: pointer !important;
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    gap: 8px !important;
                                    transition: all 0.3s ease !important;
                                    box-shadow: 0 6px 20px rgba(255, 69, 0, 0.4) !important;
                                    margin-bottom: 12px !important;
                                }

                                .shopker-order-now-btn:hover {
                                    background: linear-gradient(135deg, #e63e00 0%, #FF4500 100%) !important;
                                    box-shadow: 0 8px 24px rgba(255, 69, 0, 0.5) !important;
                                    transform: translateY(-2px);
                                }

                                .shopker-order-now-btn:active {
                                    transform: translateY(0);
                                }

                                .order-now-text {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    line-height: 1.2;
                                }

                                .order-now-title {
                                    font-weight: 900;
                                    font-size: 12px;
                                }

                                .order-now-subtitle {
                                    font-size: 11px;
                                    font-weight: 600;
                                    opacity: 0.95;
                                }

                                /* Shaky Animation - Continuous Diagonal Movement */
                                @keyframes shopker-shaky {
                                    0% {
                                        transform: translateX(-4px) translateY(-4px) rotate(-0.8deg) scale(1);
                                    }
                                    12% {
                                        transform: translateX(-6px) translateY(-6px) rotate(-1.2deg) scale(1.01);
                                    }
                                    25% {
                                        transform: translateX(6px) translateY(6px) rotate(1.2deg) scale(1.01);
                                    }
                                    37% {
                                        transform: translateX(6px) translateY(6px) rotate(1.2deg) scale(1.01);
                                    }
                                    50% {
                                        transform: translateX(6px) translateY(-6px) rotate(1.2deg) scale(1.01);
                                    }
                                    62% {
                                        transform: translateX(6px) translateY(-6px) rotate(1.2deg) scale(1.01);
                                    }
                                    75% {
                                        transform: translateX(-6px) translateY(6px) rotate(-1.2deg) scale(1.01);
                                    }
                                    87% {
                                        transform: translateX(-6px) translateY(6px) rotate(-1.2deg) scale(1.01);
                                    }
                                    100% {
                                        transform: translateX(-4px) translateY(-4px) rotate(-0.8deg) scale(1);
                                    }
                                }

                                .shopker-order-now-btn {
                                    animation: shopker-shaky 1.2s infinite !important;
                                    transform-origin: center center;
                                }

                                /* Image Lightbox Styles */
                                .image-lightbox {
                                    display: none;
                                    position: fixed;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background: rgba(0, 0, 0, 0.9);
                                    z-index: 9999;
                                    align-items: center;
                                    justify-content: center;
                                    animation: fadeIn 0.3s ease;
                                }

                                .image-lightbox.active {
                                    display: flex;
                                }

                                @keyframes fadeIn {
                                    from {
                                        opacity: 0;
                                    }
                                    to {
                                        opacity: 1;
                                    }
                                }

                                .lightbox-content {
                                    position: relative;
                                    max-width: 90vw;
                                    max-height: 90vh;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                }

                                .lightbox-image {
                                    max-width: 100%;
                                    max-height: 100%;
                                    object-fit: contain;
                                    animation: zoomIn 0.4s ease;
                                }

                                @keyframes zoomIn {
                                    from {
                                        transform: scale(0.8);
                                        opacity: 0;
                                    }
                                    to {
                                        transform: scale(1);
                                        opacity: 1;
                                    }
                                }

                                .lightbox-close {
                                    position: absolute;
                                    top: 30px;
                                    right: 30px;
                                    width: 50px;
                                    height: 50px;
                                    background: rgba(255, 255, 255, 0.1);
                                    border: 2px solid white;
                                    border-radius: 50%;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 30px;
                                    color: white;
                                    transition: all 0.3s ease;
                                }

                                .lightbox-close:hover {
                                    background: rgba(255, 255, 255, 0.2);
                                    transform: scale(1.1);
                                }

                                /* Make images clickable */
                                .product-image-clickable {
                                    cursor: pointer;
                                    transition: transform 0.3s ease;
                                }

                                .product-image-clickable:hover {
                                    transform: scale(1.02);
                                }
                            </style>

                            <!-- Quantity Selector -->
                            <div class="quantity-selector">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" class="qty-input" value="1" min="1" max="999">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>

                            <!-- Add to Cart Container -->
                            <div class="shopker-cart-container">
                                <form method="post" class="cart">
                                    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
                                    <input type="hidden" name="quantity" class="cart-quantity" value="1">
                                    <?php if ( function_exists( 'shopker_render_color_variant_inputs' ) ) : ?>
                                        <?php echo shopker_render_color_variant_inputs( $product ); ?>
                                    <?php endif; ?>
                                    <button type="submit" class="shopker-add-to-cart-btn">
                                        <span>ADD TO CART —</span>
                                        <span class="cart-price-display">RS. <span class="price-amount">0</span>.00</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Order Now Button -->
                            <button class="shopker-order-now-btn" onclick="handleOrderNow()">
                                <span>🛍️</span>
                                <span class="order-now-text">
                                    <span class="order-now-title">Order Now With Discount</span>
                                    <span class="order-now-subtitle">Limited stock available – selling fast</span>
                                </span>
                            </button>

                            <script>
                                // Get base price from the tier prices
                                let basePrice = <?php echo isset($tier_prices[1]) ? floatval($tier_prices[1]) : floatval($product->get_price()); ?>;
                                let currentPack = 1;

                                document.addEventListener('DOMContentLoaded', function() {
                                    // Quantity Selector Controls
                                    const qtyMinus = document.querySelector('.qty-minus');
                                    const qtyPlus = document.querySelector('.qty-plus');
                                    const qtyInput = document.querySelector('.qty-input');
                                    const cartQtyField = document.querySelector('.cart-quantity');
                                    const priceAmountDisplay = document.querySelector('.price-amount');

                                    // Minus button
                                    if (qtyMinus) {
                                        qtyMinus.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            let currentVal = parseInt(qtyInput.value) || 1;
                                            if (currentVal > 1) {
                                                qtyInput.value = currentVal - 1;
                                                updateCartQuantity();
                                            }
                                        });
                                    }

                                    // Plus button
                                    if (qtyPlus) {
                                        qtyPlus.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            let currentVal = parseInt(qtyInput.value) || 1;
                                            qtyInput.value = currentVal + 1;
                                            updateCartQuantity();
                                        });
                                    }

                                    // Input change handler
                                    if (qtyInput) {
                                        qtyInput.addEventListener('change', function() {
                                            let value = parseInt(this.value) || 1;
                                            if (value < 1) value = 1;
                                            this.value = value;
                                            updateCartQuantity();
                                        });
                                    }

                                    function updateCartQuantity() {
                                        const qty = parseInt(qtyInput.value) || 1;
                                        if (cartQtyField) {
                                            cartQtyField.value = qty;
                                        }
                                        
                                        // Calculate price based on current pack selection
                                        let totalPrice;
                                        if (currentPack === 2) {
                                            // Pack of 2: basePrice is already the tier price for 2 items
                                            totalPrice = Math.round(basePrice);
                                        } else {
                                            // Pack of 1: basePrice is per-item price, multiply by quantity
                                            totalPrice = Math.round(basePrice * qty);
                                        }
                                        
                                        // Update main price display (orange text above)
                                        const priceDisplay = document.querySelector('.price-display-dynamic');
                                        if (priceDisplay) {
                                            priceDisplay.textContent = 'Rs. ' + totalPrice.toLocaleString('en-PK');
                                        }
                                        
                                        // Update Add to Cart button price
                                        const cartPriceAmount = document.querySelector('.price-amount');
                                        if (cartPriceAmount) {
                                            cartPriceAmount.textContent = totalPrice.toLocaleString('en-PK');
                                        }
                                    }

                                    // Add to Cart form submission
                                    const cartForm = document.querySelector('.shopker-cart-container form');
                                    if (cartForm) {
                                        cartForm.addEventListener('submit', function(e) {
                                            const qty = parseInt(qtyInput.value) || 1;
                                            cartQtyField.value = qty;
                                        });
                                    }

                                    // Pack selector integration
                                    const packBtns = document.querySelectorAll('.pack-btn');
                                    if (packBtns.length > 0) {
                                        packBtns.forEach(btn => {
                                            btn.addEventListener('click', function() {
                                                currentPack = parseInt(this.dataset.pack);
                                                basePrice = parseFloat(this.dataset.price);
                                                
                                                // For pack of 2, set quantity to 3 (2 buy + 1 free)
                                                let displayQty = currentPack === 2 ? 3 : currentPack;
                                                qtyInput.value = displayQty;
                                                updateCartQuantity();
                                            });
                                        });
                                    }

                                    // Set initial price display
                                    const priceDisplay = document.querySelector('.price-display-dynamic');
                                    if (priceDisplay) {
                                        priceDisplay.textContent = 'Rs. ' + Math.round(basePrice).toLocaleString('en-PK');
                                    }
                                    
                                    // Set initial Add to Cart button price
                                    const cartPriceAmount = document.querySelector('.price-amount');
                                    if (cartPriceAmount) {
                                        cartPriceAmount.textContent = Math.round(basePrice).toLocaleString('en-PK');
                                    }

                                    // Initialize color variant selection if available
                                    const firstColorSwatch = document.querySelector('.shopker-color-swatch');
                                    if (firstColorSwatch) {
                                        selectColorVariant(firstColorSwatch);
                                    }

                                    // Live sold count animation
                                    const soldElement = document.getElementById('live-sold-count');
                                    if (soldElement) {
                                        function updateSoldCount() {
                                            let currentSold = parseInt(soldElement.innerText.replace(/,/g, ''));
                                            currentSold++;
                                            soldElement.innerText = currentSold.toLocaleString('en-US');
                                            const nextUpdate = Math.floor(Math.random() * (10000 - 5000 + 1)) + 5000;
                                            setTimeout(updateSoldCount, nextUpdate);
                                        }
                                        setTimeout(updateSoldCount, 5000);
                                    }
                                });

                                // Handle Order Now button - Opens modal with pack selection
                                function handleOrderNow() {
                                    const modal = document.getElementById('order-discount-modal');
                                    if (modal) {
                                        modal.style.display = 'flex';
                                        // Reset form
                                        const form = document.getElementById('order-discount-form');
                                        if (form) {
                                            form.reset();
                                        }
                                        // Set default pack selection to pack 1
                                        document.querySelectorAll('.modal-pack-btn').forEach(btn => {
                                            if (btn.dataset.pack === '1') {
                                                btn.click();
                                            }
                                        });
                                    }
                                }

                                // Close modal function
                                function closeOrderModal() {
                                    const modal = document.getElementById('order-discount-modal');
                                    if (modal) {
                                        modal.style.display = 'none';
                                    }
                                }

                                // Handle modal pack selection
                                document.addEventListener('DOMContentLoaded', function() {
                                    const modalPackBtns = document.querySelectorAll('.modal-pack-btn');
                                    modalPackBtns.forEach(btn => {
                                        btn.addEventListener('click', function() {
                                            // Remove active class from all buttons
                                            modalPackBtns.forEach(b => {
                                                b.classList.remove('border-[#1a1a1a]', 'bg-[#1a1a1a]', 'text-white');
                                                b.classList.add('border-gray-200', 'bg-white', 'text-gray-900');
                                            });
                                            // Add active class to clicked button
                                            this.classList.remove('border-gray-200', 'bg-white', 'text-gray-900');
                                            this.classList.add('border-[#1a1a1a]', 'bg-[#1a1a1a]', 'text-white');
                                            
                                            // Store selected pack
                                            const selectedPack = this.dataset.pack;
                                            const selectedPrice = this.dataset.price;
                                            document.getElementById('modal-selected-pack').value = selectedPack;
                                            document.getElementById('modal-selected-price').value = selectedPrice;
                                            
                                            // Update price display in modal
                                            const priceDisplay = document.getElementById('modal-price-display');
                                            if (priceDisplay) {
                                                priceDisplay.textContent = 'Rs. ' + parseInt(selectedPrice).toLocaleString('en-PK');
                                            }
                                            
                                            // Update pack label
                                            const packLabel = document.getElementById('modal-pack-label');
                                            if (packLabel) {
                                                packLabel.textContent = selectedPack;
                                            }
                                            
                                            // Update button price
                                            const btnPrice = document.getElementById('modal-btn-price');
                                            if (btnPrice) {
                                                btnPrice.textContent = parseInt(selectedPrice).toLocaleString('en-PK');
                                            }
                                        });
                                    });

                                    // Handle Order Now form submission
                                    const orderForm = document.getElementById('order-discount-form');
                                    if (orderForm) {
                                        orderForm.addEventListener('submit', function(e) {
                                            e.preventDefault();
                                            submitOrderDiscountForm();
                                        });
                                    }

                                    // Close modal on background click
                                    const modal = document.getElementById('order-discount-modal');
                                    if (modal) {
                                        modal.addEventListener('click', function(e) {
                                            if (e.target === this) {
                                                closeOrderModal();
                                            }
                                        });
                                    }
                                });

                                // Submit Order Discount Form
                                function submitOrderDiscountForm() {
                                    const form = document.getElementById('order-discount-form');
                                    const fullName = document.getElementById('modal-full-name').value.trim();
                                    const phone = document.getElementById('modal-phone').value.trim();
                                    const address = document.getElementById('modal-address').value.trim();
                                    const city = document.getElementById('modal-city').value.trim();
                                    const email = document.getElementById('modal-email').value.trim();
                                    const pack = document.getElementById('modal-selected-pack').value;
                                    const price = document.getElementById('modal-selected-price').value;

                                    // Basic validation
                                    if (!fullName || !phone || !address || !city || !email || !pack) {
                                        alert('Please fill in all required fields');
                                        return;
                                    }

                                    // Disable submit button
                                    const submitBtn = form.querySelector('button[type="submit"]');
                                    submitBtn.disabled = true;
                                    submitBtn.innerHTML = 'Processing...';

                                    // Send AJAX request
                                    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: new URLSearchParams({
                                            action: 'shopker_create_discount_order',
                                            nonce: '<?php echo wp_create_nonce('shopker_order_discount'); ?>',
                                            product_id: '<?php echo esc_js($product->get_id()); ?>',
                                            pack: pack,
                                            price: price,
                                            full_name: fullName,
                                            phone: phone,
                                            address: address,
                                            city: city,
                                            email: email
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Redirect to thank you page
                                            window.location.href = data.data.redirect_url;
                                        } else {
                                            alert('Error creating order: ' + data.data.message);
                                            submitBtn.disabled = false;
                                            submitBtn.innerHTML = 'Order Now - Rs.1,299.00';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('An error occurred. Please try again.');
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = 'Order Now - Rs.1,299.00';
                                    });
                                }

                                function buyNowWithPack() {
                                    const form = document.querySelector('.cart form');
                                    if (form) {
                                        const quantityInput = form.querySelector('input[name="quantity"]');
                                        if (quantityInput) {
                                            quantityInput.value = selectedPack;
                                        }
                                        const addToCartBtn = form.querySelector('.shopker-add-to-cart-btn');
                                        if (addToCartBtn) {
                                            addToCartBtn.click();
                                            setTimeout(() => {
                                                window.location.href = '<?php echo esc_url(wc_get_checkout_url()); ?>';
                                            }, 500);
                                        }
                                    }
                                }

                                // Lightbox Functions
                                function openLightbox(imageSrc) {
                                    let lightbox = document.getElementById('image-lightbox');
                                    if (!lightbox) {
                                        lightbox = document.createElement('div');
                                        lightbox.id = 'image-lightbox';
                                        lightbox.className = 'image-lightbox';
                                        document.body.appendChild(lightbox);
                                    }
                                    
                                    lightbox.innerHTML = `
                                        <div class="lightbox-content">
                                            <img src="${imageSrc}" alt="Product Image" class="lightbox-image">
                                            <div class="lightbox-close" onclick="closeLightbox()">×</div>
                                        </div>
                                    `;
                                    lightbox.classList.add('active');
                                    
                                    // Close on background click
                                    lightbox.addEventListener('click', function(e) {
                                        if (e.target === this) {
                                            closeLightbox();
                                        }
                                    });
                                    
                                    // Close on Escape key
                                    document.addEventListener('keydown', function(e) {
                                        if (e.key === 'Escape') {
                                            closeLightbox();
                                        }
                                    });
                                }

                                function closeLightbox() {
                                    const lightbox = document.getElementById('image-lightbox');
                                    if (lightbox) {
                                        lightbox.classList.remove('active');
                                    }
                                }

                                function selectProductImage(button) {
                                    if (!button) return;

                                    const fullSrc = button.dataset.full || '';
                                    const mainImage = document.getElementById('shopker-product-main-image');
                                    if (mainImage && fullSrc) {
                                        mainImage.src = fullSrc;
                                        mainImage.dataset.full = fullSrc;
                                    }

                                    document.querySelectorAll('.gallery-thumb').forEach((thumb) => {
                                        thumb.classList.remove('border-orange-500', 'ring-2', 'ring-orange-200', 'ring-orange-500');
                                        thumb.classList.add('border-gray-100');
                                    });

                                    button.classList.remove('border-gray-100');
                                    button.classList.add('border-orange-500', 'ring-2', 'ring-orange-200');
                                }

                                function selectColorVariant(button) {
                                    if (!button) return;

                                    const variationId = button.dataset.variationId || '';
                                    const attributeName = button.dataset.attributeName || '';
                                    const attributeValue = button.dataset.attributeValue || '';
                                    const imageSrc = button.dataset.imageFull || button.dataset.imageThumb || '';
                                    const mainImage = document.getElementById('shopker-product-main-image');

                                    if (mainImage && imageSrc) {
                                        mainImage.src = imageSrc;
                                        mainImage.dataset.full = imageSrc;
                                    }

                                    document.querySelectorAll('.shopker-color-swatch').forEach((swatch) => {
                                        swatch.classList.remove('border-orange-500', 'bg-orange-500', 'text-white');
                                        swatch.classList.add('border-gray-200', 'bg-white', 'text-gray-800');
                                    });

                                    button.classList.remove('border-gray-200', 'bg-white', 'text-gray-800');
                                    button.classList.add('border-orange-500', 'bg-orange-500', 'text-white');

                                    const variationField = document.querySelector('input.shopker-variation-id');
                                    if (variationField && variationId) {
                                        variationField.value = variationId;
                                    }

                                    if (attributeName && attributeValue) {
                                        let attrField = document.querySelector('input[name="' + attributeName + '"]');
                                        if (attrField) {
                                            attrField.value = attributeValue;
                                        } else {
                                            const form = document.querySelector('form.cart');
                                            if (form) {
                                                const input = document.createElement('input');
                                                input.type = 'hidden';
                                                input.name = attributeName;
                                                input.value = attributeValue;
                                                input.className = 'shopker-variation-attribute';
                                                form.appendChild(input);
                                            }
                                        }
                                    }
                                }

                                function openCurrentProductImage() {
                                    const mainImage = document.getElementById('shopker-product-main-image');
                                    if (!mainImage) return;

                                    const fullSrc = mainImage.dataset.full || mainImage.src;
                                    openLightbox(fullSrc);
                                }
                            </script>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-8 my-10 font-sans">

                        <div id="sales-notification"
                            class="bg-[#1a1a1a] text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 transition-all duration-500 transform">
                            <span class="text-red-500 text-xl">❤️</span>
                            <p class="text-sm md:text-base font-black">
                                <span id="notify-name">Noor</span> just ordered this from <span
                                    id="notify-city">Quetta</span>!
                            </p>
                        </div>

                        <div class="w-full max-w-lg px-4">
                            <div class="flex justify-between items-center relative">
                                <div class="absolute top-4 left-0 w-full h-[2px] bg-gray-200 -z-10"></div>

                                <div class="flex flex-col items-center bg-white px-2">
                                    <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-xs">
                                        🛒</div>
                                    <p class="mt-2 text-[11px] font-black text-black">
                                        <?php echo date('M d'); ?>
                                    </p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Ordered</p>
                                </div>

                                <div class="flex flex-col items-center bg-white px-2">
                                    <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-xs">
                                        🚚</div>
                                    <p class="mt-2 text-[11px] font-black text-black">
                                        <?php echo date('M d', strtotime('+1 days')) . ' – ' . date('M d', strtotime('+2 days')); ?>
                                    </p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Order Ready</p>
                                </div>

                                <div class="flex flex-col items-center bg-white px-2">
                                    <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-xs">
                                        🎁</div>
                                    <p class="mt-2 text-[11px] font-black text-black">
                                        <?php echo date('M d', strtotime('+4 days')) . ' – ' . date('M d', strtotime('+5 days')); ?>
                                    </p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Delivered</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center gap-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🔒</span>
                                <span class="text-[10px] font-black uppercase">Secure Payments</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">✅</span>
                                <span class="text-[10px] font-black uppercase">Satisfaction Guarantee</span>
                            </div>
                            <div class="flex items-center gap-2 text-orange-500">
                                <span class="text-lg">⭐</span>
                                <span class="text-[10px] font-black uppercase text-black">Premium Quality</span>
                            </div>
                        </div>

                        <p
                            class="text-[11px] font-black uppercase tracking-widest border-t border-gray-100 pt-4 w-full text-center">
                            30-DAYS FREE RETURN & EXCHANGE POLICY
                        </p>

                        <?php echo function_exists( 'shopker_render_product_video' ) ? shopker_render_product_video( $product ) : ''; ?>
                    </div>
                </div>
            </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const names = ["Ayesha", "Ali", "Zainab", "Hamza", "Fatima", "Bilal", "Sana", "Omar", "Hiba", "Mustafa"];
            const cities = ["Karachi", "Lahore", "Islamabad", "Faisalabad", "Rawalpindi", "Multan", "Peshawar", "Quetta", "Sialkot", "Gujranwala"];

            const notifyBox = document.getElementById('sales-notification');
            const nameElem = document.getElementById('notify-name');
            const cityElem = document.getElementById('notify-city');

            function updateNotification() {
                // Fade out
                notifyBox.style.opacity = '0';
                notifyBox.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    // Pick random data
                    const randomName = names[Math.floor(Math.random() * names.length)];
                    const randomCity = cities[Math.floor(Math.random() * cities.length)];

                    // Update text
                    nameElem.innerText = randomName;
                    cityElem.innerText = randomCity;

                    // Fade in
                    notifyBox.style.opacity = '1';
                    notifyBox.style.transform = 'translateY(0)';
                }, 500);
            }

            // Change every 4 seconds
            setInterval(updateNotification, 4000);
        });
    </script>
    <section class="bg-gray-50/50 py-20 border-t border-gray-100">
        <div class="max-w-2xl mx-auto px-6">
            <h3 class="text-center text-2xl font-black uppercase tracking-tighter mb-12">Product Overview</h3>
            <div
                class="prose prose-img:rounded-2xl prose-img:w-full prose-img:shadow-sm max-w-none text-gray-700 leading-relaxed font-medium">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
</div>

<!-- Order Discount Modal -->
<div id="order-discount-modal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-[#FF4500] to-[#FF6B35] text-white p-6 flex justify-between items-center sticky top-0 z-10">
            <h2 class="text-2xl font-black">🛍️ Order Now With Discount</h2>
            <button onclick="closeOrderModal()" class="text-2xl hover:scale-110 transition">×</button>
        </div>

        <!-- Modal Content -->
        <div class="p-8">
            <!-- Product Item -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-200 rounded-lg flex-shrink-0">
                    <?php
                    if ($product->get_image_id()) {
                        echo wp_get_attachment_image($product->get_image_id(), 'thumbnail', false, array('class' => 'w-full h-full object-cover rounded-lg'));
                    }
                    ?>
                </div>
                <div class="flex-1">
                    <h3 class="font-black text-gray-900"><?php the_title(); ?></h3>
                    <p class="text-sm text-gray-600 font-bold">Pack Of <span id="modal-pack-label">1</span></p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-black text-orange-600" id="modal-price-display">Rs. <?php echo number_format($tier_prices[1] ?? 0, 0); ?></p>
                </div>
            </div>

            <!-- Pack Selection -->
            <div class="mb-8">
                <p class="text-[11px] font-black uppercase tracking-widest text-gray-400 mb-3">Select Pack:</p>
                <div class="flex flex-col gap-3">
                    <?php
                    for ($qty = 1; $qty <= 2; $qty++) {
                        $is_active = $qty === 1 ? 'active' : '';
                        ?>
                        <button type="button"
                            class="modal-pack-btn w-full px-4 py-4 rounded-xl font-black uppercase text-sm transition duration-200 border-2 flex items-center justify-between <?php echo $qty === 1 ? 'border-[#1a1a1a] bg-[#1a1a1a] text-white' : 'border-gray-200 bg-white text-gray-900 hover:border-[#1a1a1a]'; ?>"
                            data-pack="<?php echo $qty; ?>" data-price="<?php echo esc_attr($tier_prices[$qty]); ?>">
                            <div class="leading-none">
                                <p class="mb-1">Pack of <?php echo $qty; ?><?php echo $qty === 2 ? ' <span class="text-orange-400">🎁 GET 1 FREE</span>' : ''; ?></p>
                                <p class="text-xs font-bold">Rs. <?php echo number_format($tier_prices[$qty], 0); ?></p>
                            </div>
                        </button>
                    <?php } ?>
                </div>
            </div>

            <!-- Order Form -->
            <form id="order-discount-form" class="space-y-4">
                <!-- Hidden fields -->
                <input type="hidden" id="modal-selected-pack" value="1">
                <input type="hidden" id="modal-selected-price" value="<?php echo esc_attr($tier_prices[1] ?? 0); ?>">

                <!-- Full Name -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Full Name *</label>
                    <input type="text" id="modal-full-name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none" placeholder="Your full name" required>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Phone *</label>
                    <input type="tel" id="modal-phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none" placeholder="03XXXXXXXXX" required>
                </div>

                <!-- Address -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Complete Address *</label>
                    <textarea id="modal-address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none" placeholder="Flat / House, Street, Area" rows="2" required></textarea>
                </div>

                <!-- City -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">City *</label>
                    <input type="text" id="modal-city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none" placeholder="Karachi, Lahore, etc." required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-bold text-gray-700 mb-2">Email *</label>
                    <input type="email" id="modal-email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none" placeholder="your@email.com" required>
                </div>

                <!-- Shipping Options -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm font-black text-gray-700 mb-3">Shipping Options</p>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="shipping" value="standard" checked class="w-4 h-4">
                        <span class="text-sm font-bold text-gray-700">Standard Shipping - Free</span>
                    </label>
                </div>

                <!-- Order Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-[#FF4500] to-[#FF6B35] text-white py-4 rounded-xl font-black uppercase mt-6 hover:shadow-lg transition transform hover:scale-105">
                    Order Now - Rs.<span id="modal-btn-price">1,299</span>.00
                </button>

                <!-- Trust Badges -->
                <div class="flex flex-wrap justify-center gap-4 pt-4 text-center">
                    <div class="text-xs">
                        <span class="text-lg">🔒</span>
                        <p class="font-bold text-gray-700">Secure Payment</p>
                    </div>
                    <div class="text-xs">
                        <span class="text-lg">🚚</span>
                        <p class="font-bold text-gray-700">Free Delivery</p>
                    </div>
                    <div class="text-xs">
                        <span class="text-lg">✅</span>
                        <p class="font-bold text-gray-700">30-Days Return</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php get_footer('shop'); ?>