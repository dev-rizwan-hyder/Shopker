<?php
/**
 * Order received template - Shopker custom theme
 * Professional order confirmation page matching Shopker design system
 */
defined('ABSPATH') || exit;

if (!$order) {
    wp_redirect(home_url('/shop'));
    exit;
}

get_header('shop');
?>

<div class="min-h-screen bg-gradient-to-b from-white to-gray-50 pb-20">
    <!-- Breadcrumb Navigation - Matches theme style -->
    <div class="py-3 px-6 md:px-10 max-w-7xl mt-[60px] mx-auto">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-gray-900 transition">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="hover:text-gray-900 transition">Checkout</a>
            <span>/</span>
            <span class="text-gray-900">Order Confirmed</span>
        </nav>
    </div>

    <!-- Main Content Section -->
    <section class="pb-16">
        <div class="mx-auto max-w-7xl px-6 md:px-10">
            <!-- Success Header - Matches checkout heading style -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    ✅ ORDER CONFIRMED
                </h1>
                <p class="text-center text-gray-600 mb-2 font-bold">Thank you for your purchase!</p>
                <p class="text-center text-gray-500 max-w-2xl mx-auto">Your order has been received and will be prepared for shipment. A confirmation email has been sent to your registered email address.</p>
            </div>

            <!-- Order Details Grid - Matches checkout summary card style -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 bg-white p-8 rounded-3xl border border-gray-100 shadow-xl">
                <div class="text-center border-r border-gray-100 last:border-r-0">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Order Number</p>
                    <p class="text-lg font-black text-gray-900 mt-2">#<?php echo $order->get_order_number(); ?></p>
                </div>
                <div class="text-center border-r border-gray-100 last:border-r-0">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Order Date</p>
                    <p class="text-lg font-black text-gray-900 mt-2"><?php echo wc_format_datetime($order->get_date_created(), 'M d, Y'); ?></p>
                </div>
                <div class="text-center border-r border-gray-100 last:border-r-0">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Payment Method</p>
                    <p class="text-lg font-black text-gray-900 mt-2"><?php echo wp_kses_post($order->get_payment_method_title()); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Order Total</p>
                    <p class="text-lg font-black text-orange-500 mt-2"><?php echo $order->get_formatted_order_total(); ?></p>
                </div>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm text-left mb-8">
                <h2 class="text-2xl font-black mb-6 flex items-center gap-3">
                    <span>📦</span> Order Details
                </h2>

                <!-- Order Items Table -->
                <div class="mb-8">
                    <h3 class="text-lg font-black mb-4">Items Ordered:</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 font-bold text-gray-700">Product</th>
                                <th class="text-center py-3 font-bold text-gray-700">Qty</th>
                                <th class="text-right py-3 font-bold text-gray-700">Price</th>
                                <th class="text-right py-3 font-bold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order->get_items() as $item) {
                                $product = $item->get_product();
                                ?>
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 text-gray-900"><?php echo wp_kses_post($item->get_name()); ?></td>
                                    <td class="text-center py-3 text-gray-600"><?php echo $item->get_quantity(); ?></td>
                                    <td class="text-right py-3 text-gray-600"><?php echo wc_price($item->get_subtotal() / $item->get_quantity()); ?></td>
                                    <td class="text-right py-3 font-bold text-gray-900"><?php echo wc_price($item->get_subtotal()); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 p-4 rounded-lg mb-8">
                    <div class="flex justify-between mb-2">
                        <span class="font-bold">Subtotal:</span>
                        <span class="font-black"><?php echo wc_price($order->get_subtotal()); ?></span>
                    </div>
                    <?php if ($order->get_shipping_total() > 0) : ?>
                        <div class="flex justify-between mb-2">
                            <span class="font-bold">Shipping:</span>
                            <span class="font-black"><?php echo wc_price($order->get_shipping_total()); ?></span>
                        </div>
                    <?php else : ?>
                        <div class="flex justify-between mb-2">
                            <span class="font-bold">Shipping:</span>
                            <span class="text-green-600 font-black">FREE ✓</span>
                        </div>
                    <?php endif; ?>
                    <?php if ($order->get_total_tax() > 0) : ?>
                        <div class="flex justify-between mb-2 border-b-2 border-gray-200 pb-2">
                            <span class="font-bold">Tax:</span>
                            <span class="font-black"><?php echo wc_price($order->get_total_tax()); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-lg font-black pt-2 border-t-2 border-gray-300">
                        <span>TOTAL:</span>
                        <span class="text-orange-500"><?php echo $order->get_formatted_order_total(); ?></span>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-black mb-3">📍 Delivery Address:</h3>
                    <p class="font-bold text-gray-900"><?php echo $order->get_formatted_billing_address(); ?></p>
                    <div class="mt-3 pt-3 border-t border-blue-100 space-y-1">
                        <p class="text-sm text-gray-600"><strong>Phone:</strong> <?php echo esc_html($order->get_billing_phone()); ?></p>
                        <p class="text-sm text-gray-600"><strong>Email:</strong> <?php echo esc_html($order->get_billing_email()); ?></p>
                    </div>
                </div>
            </div>

            <!-- What Happens Next Section -->
            <div class="bg-yellow-50 rounded-3xl p-8 border border-yellow-200 mb-8">
                <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                    <span>📋</span>
                    What Happens Next?
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black mb-3 mx-auto">1</div>
                        <p class="font-bold text-gray-900 text-sm mb-1">Confirmation</p>
                        <p class="text-xs text-gray-600">Email sent</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black mb-3 mx-auto">2</div>
                        <p class="font-bold text-gray-900 text-sm mb-1">Preparation</p>
                        <p class="text-xs text-gray-600">Being prepared</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black mb-3 mx-auto">3</div>
                        <p class="font-bold text-gray-900 text-sm mb-1">Shipment</p>
                        <p class="text-xs text-gray-600">On the way</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black mb-3 mx-auto">4</div>
                        <p class="font-bold text-gray-900 text-sm mb-1">Delivered</p>
                        <p class="text-xs text-gray-600">Pay on delivery</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Matches theme button style -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url(home_url('/shop')); ?>" 
                   class="inline-block px-10 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-black rounded-xl shadow-lg hover:shadow-xl hover:shadow-orange-500/50 transition duration-300 uppercase tracking-widest text-center">
                    🛍️ CONTINUE SHOPPING
                </a>
                <a href="<?php echo esc_url($order->get_view_order_url()); ?>" 
                   class="inline-block px-10 py-4 bg-gray-200 text-gray-900 font-black rounded-xl shadow-lg hover:bg-gray-300 transition uppercase tracking-widest text-center">
                    📊 VIEW ORDER
                </a>
            </div>
        </div>
    </section>
</div>

<script>
    jQuery(function ($) {
        // Clear the cart
        if (window.shopkerCart) {
            window.shopkerCart = [];
            sessionStorage.removeItem('shopker_cart');
            localStorage.removeItem('shopker_cart');
        }
        
        // Clear cart via AJAX
        $.post('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            action: 'woocommerce_clear_cart',
            nonce: '<?php echo wp_create_nonce('wc_clear_cart'); ?>'
        });
    });
</script>

<?php
get_footer('shop');
