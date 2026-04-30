<?php
defined('ABSPATH') || exit;

get_header('shop');

do_action('woocommerce_before_checkout_form', WC()->checkout);

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
                action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                <?php wp_nonce_field('woocommerce-process_checkout', '_wpnonce'); ?>
                <input type="hidden" name="woocommerce_checkout_update_totals" value="0">
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
                                        placeholder="Your first name" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_last_name">
                                        Last Name *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_last_name" name="billing_last_name"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_last_name')); ?>"
                                        placeholder="Your last name" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_email">
                                        Email Address *
                                    </label>
                                    <input type="email"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_email" name="billing_email"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_email')); ?>"
                                        placeholder="your@email.com" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_phone">
                                        Phone Number *
                                    </label>
                                    <input type="tel"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_phone" name="billing_phone"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_phone')); ?>"
                                        placeholder="+92-3XX-XXXXXXX" required>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_address_1">
                                        Street Address *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_address_1" name="billing_address_1"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_address_1')); ?>"
                                        placeholder="Street address" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block font-bold text-gray-700 mb-2" for="billing_city">
                                        City *
                                    </label>
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_city" name="billing_city"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_city')); ?>"
                                        placeholder="City" required>
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
                                    <input type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 outline-none"
                                        id="billing_state" name="billing_state"
                                        value="<?php echo esc_attr(WC()->checkout->get_value('billing_state')); ?>"
                                        placeholder="State or province" required>
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
                                    class="flex items-start p-4 border-2 border-orange-500 rounded-xl cursor-pointer bg-orange-50">
                                    <input type="radio" name="payment_method" value="cod" checked
                                        class="w-5 h-5 mt-1 mr-4" required>
                                    <div class="flex-1">
                                        <p class="font-black text-gray-900 text-lg mb-1">💰 Cash on Delivery</p>
                                        <p class="text-sm text-gray-600 font-bold">Pay when your order is delivered. No
                                            online payment required.</p>
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
                        <div class="bg-gradient-to-br from-gray-900 to-black text-white rounded-2xl p-8 shadow-2xl">
                            <h3 class="text-2xl font-black mb-6 flex items-center gap-2">
                                <span class="text-3xl">📦</span>
                                ORDER SUMMARY
                            </h3>

                            <!-- Order Items -->
                            <div class="space-y-3 mb-6 pb-6 border-b border-gray-700">
                                <?php
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
                                        ?>
                                        <div class="flex justify-between items-start text-sm">
                                            <div>
                                                <p class="font-bold"><?php echo wp_kses_post($_product->get_name()); ?></p>
                                                <p class="text-xs text-gray-400">Qty:
                                                    <?php echo esc_html($cart_item['quantity']); ?>
                                                </p>
                                            </div>
                                            <p class="font-black text-orange-400">
                                                <?php echo wp_kses_post(wc_price($cart_item['line_total'])); ?>
                                            </p>
                                        </div>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>

                            <!-- Pricing Details -->
                            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-700">
                                <span class="font-bold text-gray-300">Subtotal:</span>
                                <span
                                    class="text-xl font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_subtotal())); ?></span>
                            </div>

                            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-700">
                                <span class="font-bold text-gray-300">Shipping:</span>
                                <span class="text-xl font-black text-green-400">FREE ✓</span>
                            </div>

                            <?php if (wc_tax_enabled()): ?>
                                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-700">
                                    <span class="font-bold text-gray-300">Tax:</span>
                                    <span
                                        class="text-xl font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_total_tax())); ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Total -->
                            <div class="flex justify-between items-center mb-8 pt-4">
                                <span class="text-2xl font-black text-white">TOTAL:</span>
                                <span
                                    class="text-3xl font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_total('edit'))); ?></span>
                            </div>

                            <!-- Item Count -->
                            <div class="mb-6 text-center text-sm font-bold text-gray-400">
                                <p><?php echo WC()->cart->get_cart_contents_count(); ?> Item(s)</p>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" id="terms_checkbox" class="w-5 h-5 mt-1 rounded" required>
                                    <span class="text-sm font-bold text-gray-300">
                                        I agree to the <a href="<?php echo esc_url(home_url('/')); ?>"
                                            class="text-orange-400 hover:text-orange-300">Terms & Conditions</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" name="woocommerce_checkout_place_order" id="place-order-btn"
                                value="Place order"
                                class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-black uppercase rounded-xl hover:shadow-2xl hover:shadow-orange-500/50 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                🔒 PLACE ORDER
                            </button>

                            <p class="text-xs text-gray-400 text-center mt-4">
                                You will receive an order confirmation via email
                            </p>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="post_data" value="">
            </form>
        </div>
    </section>
</div>

<script>
    document.getElementById('terms_checkbox').addEventListener('change', function () {
        document.getElementById('place-order-btn').disabled = !this.checked;
    });

    document.getElementById('order_comments').addEventListener('change', function () {
        document.getElementById('order-comments-field').style.display = this.checked ? 'block' : 'none';
    });

    // Form validation
    document.querySelector('form.checkout').addEventListener('submit', function (e) {
        const requiredFields = ['billing_first_name', 'billing_last_name', 'billing_email', 'billing_phone', 'billing_address_1', 'billing_city', 'billing_state'];

        for (let field of requiredFields) {
            const input = document.getElementById(field);
            if (!input || !input.value.trim()) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
        }

        if (!document.getElementById('terms_checkbox').checked) {
            e.preventDefault();
            alert('Please agree to the Terms & Conditions');
            return false;
        }
    });

    jQuery(function ($) {
        // Sync Terms Checkbox with button
        $('#terms_checkbox').on('change', function () {
            $('#place-order-btn').prop('disabled', !this.checked);
        });

        $('#order_comments').on('change', function () {
            $('#order-comments-field').toggle(this.checked);
        });

        // Custom Submit Handler to bridge with WooCommerce
        $('form.checkout').on('submit', function (e) {
            var $form = $(this);

            // Basic validation check before letting WooCommerce take over
            const requiredFields = ['billing_first_name', 'billing_last_name', 'billing_email', 'billing_phone', 'billing_address_1', 'billing_city', 'billing_state'];
            let valid = true;

            requiredFields.forEach(field => {
                const input = $('#' + field);
                if (!input.val() || input.val().trim() === '') {
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }

            if (!$('#terms_checkbox').is(':checked')) {
                e.preventDefault();
                alert('Please agree to the Terms & Conditions');
                return false;
            }

            // If valid, WooCommerce checkout.js will normally pick this up 
            // via the button name="woocommerce_checkout_place_order"
        });
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
