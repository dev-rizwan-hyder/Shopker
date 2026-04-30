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
                    ?>

                    <div class="hidden md:flex flex-col gap-3 w-20">
                        <?php if ($attachment_ids):
                            foreach ($attachment_ids as $attachment_id): ?>
                                <div
                                    class="cursor-pointer rounded-lg border border-gray-100 overflow-hidden hover:border-orange-500 transition">
                                    <img src="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'thumbnail')); ?>"
                                        class="w-full aspect-square object-cover">
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>

                    <div class="flex-1">
                        <div class="rounded-2xl border border-gray-50 overflow-hidden shadow-sm">
                            <img src="<?php echo esc_url(wp_get_attachment_image_url($main_image_id, 'full')); ?>"
                                class="w-full h-auto">
                        </div>
                        <div class="flex md:hidden gap-2 mt-4 overflow-x-auto">
                            <?php foreach ($attachment_ids as $attachment_id): ?>
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'thumbnail')); ?>"
                                    class="w-16 h-16 rounded-lg object-cover border">
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

                    <div class="mb-8">
                        <p class="text-[11px] font-black uppercase tracking-widest text-gray-400 mb-3">Select Pack:</p>
                        <div class="flex flex-wrap gap-3" id="pack-selector">
                            <?php
                            $tiers = shopker_get_tier_pricing_data($product->get_id());
                            $tier_prices = array();
                            $base_price = floatval($product->get_price());

                            // Set Pack of 1 to base price (no tier discount)
                            $tier_prices[1] = $base_price;

                            // For packs 2 and 3, use tier pricing if available, else apply basic discount
                            for ($qty = 2; $qty <= 3; $qty++) {
                                $tier_price = shopker_get_applicable_tier_price($qty, $tiers);

                                // If no tier pricing is set, apply a simple discount (10% for pack 2, 15% for pack 3)
                                if ($tier_price <= 0 || $tier_price === $base_price) {
                                    $discount = ($qty === 2) ? 0.10 : 0.15;
                                    $tier_price = $base_price * $qty * (1 - $discount);
                                }

                                $tier_prices[$qty] = $tier_price;
                            }

                            for ($qty = 1; $qty <= 3; $qty++) {
                                $is_active = $qty === 1 ? 'active' : '';
                                ?>
                                <button type="button"
                                    class="pack-btn flex-1 px-4 py-3 rounded-xl font-black uppercase text-xs transition duration-200 border-2 <?php echo $qty === 1 ? 'border-[#1a1a1a] bg-[#1a1a1a] text-white' : 'border-gray-200 bg-white text-gray-900 hover:border-[#1a1a1a]'; ?>"
                                    data-pack="<?php echo $qty; ?>" data-price="<?php echo esc_attr($tier_prices[$qty]); ?>"
                                    onclick="selectPack(<?php echo $qty; ?>)">
                                    <div class="leading-none">
                                        <p class="mb-1">Pack of <?php echo $qty; ?></p>
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
                            </style>

                            <?php woocommerce_template_single_add_to_cart(); ?>

                            <script>
                                // Handle Add to Cart button click - use global sidebar
                                document.addEventListener('DOMContentLoaded', function() {
                                    const addToCartBtn = document.querySelector('.single_add_to_cart_button');
                                    
                                    if (addToCartBtn) {
                                        const originalClick = addToCartBtn.onclick;
                                        addToCartBtn.addEventListener('click', function(e) {
                                            // Timer to show sidebar after redirect
                                            setTimeout(() => {
                                                if (typeof openCartSidebar === 'function') {
                                                    openCartSidebar();
                                                }
                                            }, 500);
                                        });
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

                                function buyNowWithPack() {
                                    const form = document.querySelector('.cart form');
                                    if (form) {
                                        const quantityInput = form.querySelector('input[name="quantity"]');
                                        if (quantityInput) {
                                            quantityInput.value = selectedPack;
                                        }
                                        const addToCartBtn = form.querySelector('.single_add_to_cart_button');
                                        if (addToCartBtn) {
                                            addToCartBtn.value = 'Add to Cart';
                                            addToCartBtn.click();
                                            setTimeout(() => {
                                                window.location.href = '<?php echo esc_url(wc_get_checkout_url()); ?>';
                                            }, 500);
                                        }
                                    }
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

<?php get_footer('shop'); ?>