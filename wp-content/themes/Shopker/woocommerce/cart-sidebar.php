<?php
/**
 * Cart Sidebar Template
 * Displays order summary and checkout button
 */
defined('ABSPATH') || exit;
?>

<div class="bg-gradient-to-br from-gray-900 to-black text-white rounded-3xl p-8 shadow-2xl">
    <h3 class="text-2xl font-black mb-6 flex items-center gap-2">
        <span class="text-3xl">💳</span>
        ORDER SUMMARY
    </h3>

    <!-- Order Items -->
    <div class="space-y-3 mb-6 pb-6 border-b border-gray-700">
        <?php
        $cart_total = 0;
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
                $item_total = $cart_item['line_total'];
                $cart_total += $item_total;
                ?>
                <div class="flex justify-between items-start text-sm">
                    <div>
                        <p class="font-bold"><?php echo wp_kses_post($_product->get_name()); ?></p>
                        <p class="text-xs text-gray-400">Qty: <?php echo esc_html($cart_item['quantity']); ?></p>
                    </div>
                    <p class="font-black text-orange-400">
                        <?php echo wp_kses_post(wc_price($item_total)); ?>
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
        <span class="text-xl font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_subtotal())); ?></span>
    </div>

    <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-700">
        <span class="font-bold text-gray-300">Shipping:</span>
        <span class="text-xl font-black text-green-400">FREE ✓</span>
    </div>

    <?php if (wc_tax_enabled()): ?>
        <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-700">
            <span class="font-bold text-gray-300">Tax:</span>
            <span class="text-xl font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_total_tax())); ?></span>
        </div>
    <?php endif; ?>

    <!-- Total -->
    <div class="flex justify-between items-center mb-8 pt-4">
        <span class="text-2xl font-black text-white">TOTAL:</span>
        <span class="text-3xl font-black text-orange-400"><?php echo wp_kses_post(wc_price(WC()->cart->get_total('edit'))); ?></span>
    </div>

    <!-- Item Count -->
    <div class="mb-6 text-center text-sm font-bold text-gray-400">
        <p><?php echo WC()->cart->get_cart_contents_count(); ?> Item(s)</p>
    </div>

    <!-- Proceed to Checkout Button -->
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" 
       class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-black uppercase rounded-xl hover:shadow-2xl hover:shadow-orange-500/50 transition duration-300 transform hover:scale-105 block text-center mb-3">
        🔒 PROCEED TO CHECKOUT
    </a>

    <!-- Continue Shopping Link -->
    <a href="<?php echo esc_url(home_url('/shop')); ?>" 
       class="w-full py-3 border-2 border-gray-600 text-gray-300 font-black uppercase rounded-xl hover:border-orange-500 hover:text-orange-400 transition text-center block">
        ← CONTINUE SHOPPING
    </a>

    <!-- Trust Badges -->
    <div class="mt-8 space-y-3 pt-6 border-t border-gray-700">
        <div class="flex items-start gap-3">
            <span class="text-xl">🔒</span>
            <div>
                <p class="text-xs font-black text-gray-400">SECURE CHECKOUT</p>
                <p class="text-xs text-gray-500">Encrypted payment</p>
            </div>
        </div>
        <div class="flex items-start gap-3">
            <span class="text-xl">✅</span>
            <div>
                <p class="text-xs font-black text-gray-400">100% GUARANTEED</p>
                <p class="text-xs text-gray-500">Money back if not satisfied</p>
            </div>
        </div>
        <div class="flex items-start gap-3">
            <span class="text-xl">🚀</span>
            <div>
                <p class="text-xs font-black text-gray-400">FAST DELIVERY</p>
                <p class="text-xs text-gray-500">Quick shipping all over Pakistan</p>
            </div>
        </div>
    </div>
</div>
