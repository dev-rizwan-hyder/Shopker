<?php
/**
 * Shopker Custom Checkout Page - Optimized & Error-Free
 * 
 * This is a simplified checkout page that avoids memory issues
 * and provides a smooth checkout experience for COD orders.
 */

defined('ABSPATH') || exit;

get_header('shop');

// Redirect empty cart
if (empty(WC()->cart->get_cart())) {
    ?>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
            <a href="<?php echo esc_url(home_url('/shop')); ?>"
                class="inline-block px-8 py-4 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition">
                🛍️ CONTINUE SHOPPING
            </a>
        </div>
    </div>
    <?php
    get_footer('shop');
    return;
}

do_action('woocommerce_before_checkout_form', WC()->checkout());
?>

<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <div class="py-3 px-6 md:px-10 max-w-7xl mt-[60px] mx-auto">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>">Cart</a>
            <span>/</span>
            <span class="text-gray-900">Checkout</span>
        </nav>
    </div>

    <section class="pb-16">
        <div class="mx-auto max-w-7xl px-6 md:px-10">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 text-center">
                🛒 SECURE CHECKOUT
            </h1>
            <p class="text-center text-gray-600 mb-12 font-bold">Complete your order safely</p>

            <!-- Progress Steps -->
            <div class="flex justify-center gap-4 mb-12">
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black">
                        1</div>
                    <p class="text-xs font-bold mt-2 text-gray-600">Delivery</p>
                </div>
                <div class="w-24 h-1 bg-gray-300 mt-5"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black">
                        2</div>
                    <p class="text-xs font-bold mt-2 text-gray-600">Payment</p>
                </div>
                <div class="w-24 h-1 bg-gray-300 mt-5"></div>
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-black">
                        3</div>
                    <p class="text-xs font-bold mt-2 text-gray-600">Confirm</p>
                </div>
            </div>

            <form name="checkout" method="post" class="checkout woocommerce-checkout"
                action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" novalidate>

                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2">
                        <!-- Billing Details -->
                        <div class="bg-white rounded-2xl p-8 mb-8 shadow-sm border border-gray-100">
                            <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                                <span class="text-3xl">📍</span>
                                Delivery Address
                            </h2>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_first_name">
                                        First Name *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_first_name" name="billing_first_name"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_first_name')); ?>"
                                        placeholder="Your first name">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_last_name">
                                        Last Name *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_last_name" name="billing_last_name"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_last_name')); ?>"
                                        placeholder="Your last name">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_email">
                                        Email Address *
                                    </label>
                                    <input type="email"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_email" name="billing_email"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_email')); ?>"
                                        placeholder="your@email.com">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_phone">
                                        Phone Number *
                                    </label>
                                    <input type="tel"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_phone" name="billing_phone"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_phone')); ?>"
                                        placeholder="+92-3XX-XXXXXXX">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_address_1">
                                        Street Address *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_address_1" name="billing_address_1"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_address_1')); ?>"
                                        placeholder="Street address">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_city">
                                        City *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_city" name="billing_city"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_city')); ?>"
                                        placeholder="City">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_postcode">
                                        Postal Code
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_postcode" name="billing_postcode"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_postcode')); ?>"
                                        placeholder="Postal code">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_state">
                                        State / Province *
                                    </label>
                                    <select
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_state" name="billing_state" required>
                                        <option value="">-- Select State --</option>
                                        <option value="Azad Kashmir" <?php selected(WC()->checkout->get_value('billing_state'), 'Azad Kashmir'); ?>>
                                            Azad Kashmir</option>
                                        <option value="Balochistan" <?php selected(WC()->checkout->get_value('billing_state'), 'Balochistan'); ?>>
                                            Balochistan</option>
                                        <option value="Chattogram" <?php selected(WC()->checkout->get_value('billing_state'), 'Chattogram'); ?>>
                                            Chattogram (Chittagong)</option>
                                        <option value="Gilgit-Baltistan" <?php selected(WC()->checkout->get_value('billing_state'), 'Gilgit-Baltistan'); ?>>Gilgit-Baltistan</option>
                                        <option value="Islamabad" <?php selected(WC()->checkout->get_value('billing_state'), 'Islamabad'); ?>>
                                            Islamabad</option>
                                        <option value="Khyber Pakhtunkhwa" <?php selected(WC()->checkout->get_value('billing_state'), 'Khyber Pakhtunkhwa'); ?>>Khyber Pakhtunkhwa</option>
                                        <option value="Punjab" <?php selected(WC()->checkout->get_value('billing_state'), 'Punjab'); ?>>Punjab
                                        </option>
                                        <option value="Sindh" <?php selected(WC()->checkout->get_value('billing_state'), 'Sindh'); ?>>Sindh</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="order_comments" name="order_comments_flag"
                                            class="w-4 h-4 rounded" value="1">
                                        <span class="font-bold text-gray-700">Add special instructions</span>
                                    </label>
                                </div>

                                <div class="md:col-span-2" id="order-comments-field" style="display:none;">
                                    <textarea
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="order_comments_text" name="order_comments"
                                        placeholder="Special instructions for delivery..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                            <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                                <span class="text-3xl">💳</span>
                                Payment Method
                            </h2>

                            <div class="space-y-4">
                                <label
                                    class="flex items-start p-4 border-2 border-orange-500 rounded-xl cursor-pointer bg-orange-50 hover:bg-orange-100 transition">
                                    <input type="radio" name="payment_method" value="shopker_cod" checked
                                        class="w-5 h-5 mt-1 mr-4 cursor-pointer" id="payment_method_shopker_cod">
                                    <div class="flex-1 cursor-pointer">
                                        <p class="font-black text-gray-900 text-lg mb-1">💰 Cash on Delivery (COD)</p>
                                        <p class="text-sm text-gray-600 font-bold">Pay when your order is delivered at
                                            your doorstep. No online payment required. Our delivery partner will collect
                                            payment.</p>
                                        <ul class="text-xs text-gray-600 mt-2 space-y-1 font-bold">
                                            <li>✓ Safe & Secure</li>
                                            <li>✓ Pay Only When Delivered</li>
                                            <li>✓ No Hidden Charges</li>
                                        </ul>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <p class="text-sm font-bold text-green-700 flex items-center gap-2">
                                    <span class="text-lg">✓</span>
                                    Only Cash on Delivery payment method is available for now.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="lg:col-span-1 h-fit lg:sticky lg:top-10">
                        <div class="bg-gradient-to-br from-gray-900 to-black text-white rounded-3xl p-8 shadow-2xl border border-gray-800">
                            <h3 class="text-2xl font-black mb-6 flex items-center gap-2">
                                <span class="text-3xl">📦</span>
                                ORDER SUMMARY
                            </h3>

                            <!-- Item Count Badge -->
                            <div class="mb-6 inline-block px-4 py-2 bg-orange-600 rounded-full">
                                <p class="text-sm font-black">🛍️ <?php echo WC()->cart->get_cart_contents_count(); ?> Item<?php echo WC()->cart->get_cart_contents_count() !== 1 ? 's' : ''; ?></p>
                            </div>

                            <!-- Order Items with Images -->
                            <div class="space-y-4 mb-8 pb-8 border-b border-gray-700">
                                <?php
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
                                        $product_image = wp_get_attachment_image_url($_product->get_image_id(), 'thumbnail');
                                        ?>
                                        <div class="flex gap-4 pb-4 border-b border-gray-800 last:border-b-0 last:pb-0">
                                            <!-- Product Image -->
                                            <div class="w-16 h-16 flex-shrink-0 bg-gray-800 rounded-lg overflow-hidden flex items-center justify-center">
                                                <?php if ($product_image) : ?>
                                                    <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($_product->get_name()); ?>" class="w-full h-full object-cover">
                                                <?php else : ?>
                                                    <span class="text-2xl">📦</span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold text-sm text-white truncate"><?php echo wp_kses_post($_product->get_name()); ?></p>
                                                <p class="text-xs text-gray-400 mt-1">Qty: <span class="font-black text-orange-400"><?php echo esc_html($cart_item['quantity']); ?></span></p>
                                                <p class="text-sm font-black text-orange-400 mt-1">
                                                    <?php echo wp_kses_post(wc_price($cart_item['line_total'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>

                            <!-- Pricing Breakdown -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-300">Subtotal</span>
                                    <span class="text-lg font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_subtotal())); ?></span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-300">Shipping</span>
                                    <span class="text-lg font-black text-green-400">FREE ✓</span>
                                </div>

                                <?php if (wc_tax_enabled()): ?>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-300">Tax</span>
                                        <span class="text-lg font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_total_tax())); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Total Section -->
                            <div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-2xl p-4 mb-8">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-black">ORDER TOTAL</span>
                                    <span class="text-3xl font-black">
                                        <?php echo wp_kses_post(wc_price(WC()->cart->get_total('edit'))); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="mb-6 p-4 bg-gray-800 rounded-xl">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" id="terms_checkbox" name="woocommerce_checkout_terms"
                                        class="w-5 h-5 mt-0.5 rounded accent-orange-500" value="1" required>
                                    <span class="text-xs font-bold text-gray-300 leading-relaxed">
                                        I agree to the <a href="<?php echo esc_url(home_url('/')); ?>"
                                            class="text-orange-400 hover:text-orange-300 underline">Terms & Conditions</a> and <a href="<?php echo esc_url(home_url('/')); ?>"
                                            class="text-orange-400 hover:text-orange-300 underline">Privacy Policy</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" name="woocommerce_checkout_place_order" id="place-order-btn"
                                value="Place order"
                                class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-black uppercase rounded-xl hover:shadow-2xl hover:shadow-orange-500/50 transition duration-300 transform hover:scale-105 text-center">
                                🔒 PLACE ORDER
                            </button>

                            <p class="text-xs text-gray-400 text-center mt-4 leading-relaxed">
                                ✓ Secure checkout with payment on delivery<br>
                                ✓ Order confirmation sent to your email
                            </p>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-6 border-t border-gray-700 space-y-3">
                                <div class="flex items-start gap-2 text-xs">
                                    <span class="text-lg flex-shrink-0">🔒</span>
                                    <span class="text-gray-400"><span class="text-orange-400 font-bold">Secure</span> - Your data is encrypted</span>
                                </div>
                                <div class="flex items-start gap-2 text-xs">
                                    <span class="text-lg flex-shrink-0">✅</span>
                                    <span class="text-gray-400"><span class="text-orange-400 font-bold">Guaranteed</span> - Money back if unsatisfied</span>
                                </div>
                                <div class="flex items-start gap-2 text-xs">
                                    <span class="text-lg flex-shrink-0">🚀</span>
                                    <span class="text-gray-400"><span class="text-orange-400 font-bold">Fast</span> - Quick delivery across Pakistan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <input type="hidden" name="post_data" value="">
            </form>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderCommentsCheckbox = document.getElementById('order_comments');
        const orderCommentsField = document.getElementById('order-comments-field');

        // Toggle comments field
        if (orderCommentsCheckbox) {
            orderCommentsCheckbox.addEventListener('change', function () {
                orderCommentsField.style.display = this.checked ? 'block' : 'none';
            });
        }

        // Serialize form data to post_data hidden field (required by WooCommerce)
        const checkoutForm = document.querySelector('.checkout.woocommerce-checkout');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function (e) {
                console.log('Shopker: Checkout form submitted');

                // Serialize form data
                const formData = new FormData(this);
                const postData = new URLSearchParams(formData).toString();

                // Set the post_data field
                const postDataField = document.querySelector('input[name="post_data"]');
                if (postDataField) {
                    postDataField.value = postData;
                    console.log('Shopker: Set post_data field for WooCommerce processing');
                }
            });
        }

        console.log('Shopker Checkout: Traditional POST form submission configured');
    });
</script>

<style>
    .checkout input[type="text"],
    .checkout input[type="email"],
    .checkout input[type="tel"],
    .checkout textarea {
        transition: all 0.3s ease;
    }

    .checkout input[type="text"]:focus,
    .checkout input[type="email"]:focus,
    .checkout input[type="tel"]:focus,
    .checkout textarea:focus {
        box-shadow: 0 0 0 3px rgba(255, 69, 0, 0.1);
    }
</style>

<?php
do_action('woocommerce_after_checkout_form', WC()->checkout);
get_footer('shop');
