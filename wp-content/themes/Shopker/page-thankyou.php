<?php
/**
 * Template Name: Shopker Thank You Page
 * Description: Custom order confirmation page
 */

defined('ABSPATH') || exit;

get_header('shop');

// Get the order ID from the URL
$order_id = get_query_var('order-received');
$order    = $order_id ? wc_get_order($order_id) : false;
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
        <?php if ($order) : ?>
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
                <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
                <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
            </div>

            <a href="<?php echo esc_url(home_url('/shop')); ?>" 
               class="inline-block px-10 py-4 bg-gradient-to-r from-[#FF6F00] to-[#FF4500] text-white font-black rounded-xl shadow-lg hover:scale-105 transition-transform uppercase tracking-widest">
                Continue Shopping
            </a>

        <?php else : ?>
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), null); ?>
            </p>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Mimicking your Checkout CSS for consistency */
    .woocommerce-order-details__title { font-size: 1.5rem; font-weight: 900; margin-bottom: 1.5rem; }
    .woocommerce-table--order-details { width: 100%; margin-bottom: 2rem; border-collapse: collapse; }
    .woocommerce-table--order-details td, .woocommerce-table--order-details th { padding: 12px; border-bottom: 1px solid #f3f4f6; }
    .woocommerce-customer-details address { font-style: normal; background: #fafafa; padding: 20px; border-radius: 15px; border: 1px solid #eee; }
</style>

<?php
get_footer('shop');