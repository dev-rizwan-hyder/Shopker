<?php
/**
 * Order received template - Shopker custom theme
 */
defined('ABSPATH') || exit;

if (!$order) {
    // No order found, redirect to shop
    wp_redirect(home_url('/shop'));
    exit;
}

get_header('shop');
?>

<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-gray-100 pb-20">
    <div class="py-4 px-6 md:px-10 max-w-7xl mt-16 mx-auto">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-500">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-[#FF6F00] transition">Home</a>
            <span class="text-gray-300">/</span>
            <span class="text-[#FF6F00]">Order Confirmed</span>
        </nav>
    </div>

    <div class="mx-auto max-w-4xl px-6 md:px-10 text-center">
        <div class="inline-block mb-8 p-6 bg-green-100 rounded-full animate-bounce">
            <span class="text-6xl">🎉</span>
        </div>

        <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-4 bg-gradient-to-r from-gray-900 via-[#FF4500] to-gray-900 bg-clip-text text-transparent">
            THANK YOU!
        </h1>
        <p class="text-xl text-gray-600 mb-12">Your order has been received and is being processed.</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 bg-white p-8 rounded-3xl border border-gray-100 shadow-xl">
            <div class="text-center border-r border-gray-100">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Order Number</p>
                <p class="text-lg font-black text-gray-900">#<?php echo $order->get_order_number(); ?></p>
            </div>
            <div class="text-center border-r border-gray-100">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Date</p>
                <p class="text-lg font-black text-gray-900"><?php echo wc_format_datetime($order->get_date_created()); ?></p>
            </div>
            <div class="text-center border-r border-gray-100">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Total</p>
                <p class="text-lg font-black text-[#FF6F00]"><?php echo $order->get_formatted_order_total(); ?></p>
            </div>
            <div class="text-center">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">Payment</p>
                <p class="text-lg font-black text-gray-900"><?php echo wp_kses_post($order->get_payment_method_title()); ?></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm text-left mb-8">
            <h2 class="text-2xl font-black mb-6 flex items-center gap-3">
                <span>📦</span> Order Details
            </h2>
            
            <!-- Order Items -->
            <div class="mb-8">
                <h3 class="text-lg font-black mb-4">Items Ordered:</h3>
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 font-bold">Product</th>
                            <th class="text-center py-3 font-bold">Qty</th>
                            <th class="text-right py-3 font-bold">Price</th>
                            <th class="text-right py-3 font-bold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order->get_items() as $item) {
                            $product = $item->get_product();
                            ?>
                            <tr class="border-b border-gray-100">
                                <td class="py-3"><?php echo wp_kses_post($item->get_name()); ?></td>
                                <td class="text-center py-3"><?php echo $item->get_quantity(); ?></td>
                                <td class="text-right py-3"><?php echo wc_price($item->get_subtotal() / $item->get_quantity()); ?></td>
                                <td class="text-right py-3 font-bold"><?php echo wc_price($item->get_subtotal()); ?></td>
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
                    <span><?php echo wc_price($order->get_subtotal()); ?></span>
                </div>
                <?php if ($order->get_shipping_total() > 0) : ?>
                    <div class="flex justify-between mb-2">
                        <span class="font-bold">Shipping:</span>
                        <span><?php echo wc_price($order->get_shipping_total()); ?></span>
                    </div>
                <?php else : ?>
                    <div class="flex justify-between mb-2">
                        <span class="font-bold">Shipping:</span>
                        <span class="text-green-600 font-bold">FREE ✓</span>
                    </div>
                <?php endif; ?>
                <?php if ($order->get_total_tax() > 0) : ?>
                    <div class="flex justify-between mb-2 border-b-2 border-gray-200 pb-2">
                        <span class="font-bold">Tax:</span>
                        <span><?php echo wc_price($order->get_total_tax()); ?></span>
                    </div>
                <?php endif; ?>
                <div class="flex justify-between text-lg font-black">
                    <span>TOTAL:</span>
                    <span class="text-[#FF6F00]"><?php echo $order->get_formatted_order_total(); ?></span>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-black mb-3">📍 Delivery Address:</h3>
                <p class="font-bold"><?php echo $order->get_formatted_billing_address(); ?></p>
            </div>
        </div>

        <a href="<?php echo esc_url(home_url('/shop')); ?>" 
           class="inline-block px-10 py-4 bg-gradient-to-r from-[#FF6F00] to-[#FF4500] text-white font-black rounded-xl shadow-lg hover:scale-105 transition-transform uppercase tracking-widest">
            Continue Shopping
        </a>
    </div>
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

<style>
    .woocommerce-order-details__title { font-size: 1.5rem; font-weight: 900; margin-bottom: 1.5rem; }
    .woocommerce-table--order-details { width: 100%; margin-bottom: 2rem; border-collapse: collapse; }
    .woocommerce-table--order-details td, .woocommerce-table--order-details th { padding: 12px; border-bottom: 1px solid #f3f4f6; }
    .woocommerce-customer-details address { font-style: normal; background: #fafafa; padding: 20px; border-radius: 15px; border: 1px solid #eee; }
</style>

<?php
get_footer('shop');
