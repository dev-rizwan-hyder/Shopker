<?php
/**
 * Template Name: Shopker Cart Page
 * Template Post Type: page
 * Description: Custom cart page template with Shopker styling
 */

defined('ABSPATH') || exit;

get_header('shop');

do_action('woocommerce_before_cart');
?>

<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-gray-100">
    <!-- Breadcrumb -->
    <div class="py-4 px-6 md:px-10 max-w-7xl mt-16 mx-auto">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-500">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-[#FF6F00] transition">Home</a>
            <span class="text-gray-300">/</span>
            <span class="text-[#FF6F00]">Shopping Cart</span>
        </nav>
    </div>

    <section class="pb-20 pt-6">
        <div class="mx-auto max-w-7xl px-6 md:px-10">
            <!-- Header with Animation -->
            <div class="text-center mb-16">
                <div class="inline-block mb-6 p-4 bg-gradient-to-br from-[#FF6F00]/10 to-[#FF4500]/10 rounded-2xl">
                    <span class="text-6xl">🛒</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-3 bg-gradient-to-r from-gray-900 via-[#FF4500] to-gray-900 bg-clip-text text-transparent">
                    YOUR SHOPPING CART
                </h1>
                <p class="text-lg text-gray-600">Review your items and proceed to checkout</p>
            </div>

            <?php if (!WC()->cart->is_empty()): ?>
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Cart Items Section -->
                    <div class="lg:col-span-2 space-y-4">
                        <!-- Cart Item Count Badge -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="px-4 py-2 bg-gradient-to-r from-[#FF6F00] to-[#FF4500] text-white rounded-full font-black text-sm">
                                📦 <?php echo WC()->cart->get_cart_contents_count(); ?> Item<?php echo WC()->cart->get_cart_contents_count() !== 1 ? 's' : ''; ?>
                            </div>
                        </div>

                        <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" class="space-y-4">
                            <?php
                            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
                            ?>
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-[#FF6F00]/30 transition duration-300 group">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Product Image -->
                                    <div class="w-full md:w-32 h-32 flex-shrink-0 bg-white rounded-xl overflow-hidden flex items-center justify-center">
                                        <a href="<?php echo esc_url($_product->get_permalink()); ?>" class="block w-full h-full">
                                            <?php echo wp_kses_post($_product->get_image('woocommerce_thumbnail')); ?>
                                        </a>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="text-xl font-black text-gray-900 mb-3 group-hover:text-[#FF6F00] transition">
                                            <a href="<?php echo esc_url($_product->get_permalink()); ?>">
                                                <?php echo wp_kses_post($_product->get_name()); ?>
                                            </a>
                                        </h3>

                                        <div class="space-y-2 mb-4">
                                            <div class="flex items-center gap-4">
                                                <span class="text-sm text-gray-500 font-bold">SKU: <span class="text-gray-900 font-black"><?php echo esc_html($_product->get_sku()); ?></span></span>
                                                <span class="text-3xl font-black text-[#FF4500]"><?php echo wp_kses_post($_product->get_price_html()); ?></span>
                                            </div>
                                        </div>

                                        <!-- Quantity & Actions -->
                                        <div class="flex flex-wrap items-center gap-3">
                                            <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-1">
                                                <label class="text-sm font-black text-gray-700 px-3">QTY:</label>
                                                <input type="number" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                                                    value="<?php echo esc_attr($cart_item['quantity']); ?>" min="1" max="999"
                                                    class="w-20 px-3 py-2 border border-gray-200 rounded-lg font-black text-center text-lg focus:outline-none focus:border-[#FF4500]"
                                                    title="Qty" />
                                            </div>

                                            <button type="submit" name="update_cart"
                                                class="px-5 py-2 bg-gradient-to-r from-[#FF6F00] to-[#FF4500] text-white rounded-lg font-black text-sm hover:shadow-lg hover:shadow-[#FF4500]/30 transition transform hover:scale-105">
                                                ↻ UPDATE
                                            </button>

                                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                                                class="px-5 py-2 bg-red-50 text-red-600 rounded-lg font-black text-sm hover:bg-red-100 transition">
                                                🗑️ REMOVE
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right border-l border-gray-100 pl-6 md:min-w-fit">
                                        <p class="text-sm font-bold text-gray-500 mb-2">SUBTOTAL</p>
                                        <p class="text-3xl font-black text-gray-900"><?php echo wp_kses_post(wc_price($cart_item['line_total'])); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                                endif;
                            endforeach;
                            ?>

                            <!-- Continue Shopping Button -->
                            <div class="pt-6">
                                <a href="<?php echo esc_url(home_url('/shop')); ?>"
                                    class="inline-block px-8 py-4 border-2 border-[#FF6F00] text-[#FF6F00] rounded-xl font-black text-lg hover:bg-[#FF6F00] hover:text-white transition duration-300 transform hover:scale-105">
                                    ← CONTINUE SHOPPING
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Cart Sidebar / Summary -->
                    <div class="lg:col-span-1 h-fit lg:sticky lg:top-24">
                        <?php get_template_part('woocommerce/cart-sidebar'); ?>
                        
                        <!-- Trust Badges -->
                        <div class="mt-8 p-6 bg-white rounded-2xl border border-gray-100 space-y-4">
                            <div class="flex items-start gap-3">
                                <span class="text-3xl">🔒</span>
                                <div>
                                    <p class="font-black text-gray-900">Secure Checkout</p>
                                    <p class="text-xs text-gray-600">Your payment is encrypted & safe</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-3xl">✅</span>
                                <div>
                                    <p class="font-black text-gray-900">Guaranteed Quality</p>
                                    <p class="text-xs text-gray-600">100% satisfaction or money back</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-3xl">🚀</span>
                                <div>
                                    <p class="font-black text-gray-900">Fast Delivery</p>
                                    <p class="text-xs text-gray-600">Quick shipping to your door</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Empty Cart State -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-3xl p-12 shadow-lg border border-gray-100 text-center">
                        <div class="mb-8">
                            <div class="inline-block p-6 bg-gradient-to-br from-[#FF6F00]/10 to-[#FF4500]/10 rounded-3xl">
                                <span class="text-8xl">🛒</span>
                            </div>
                        </div>
                        
                        <h2 class="text-4xl font-black text-gray-900 mb-4">Your Cart is Empty</h2>
                        <p class="text-lg text-gray-600 mb-4">Looks like you haven't added anything yet.</p>
                        <p class="text-gray-500 mb-10">Start shopping and find amazing products!</p>
                        
                        <a href="<?php echo esc_url(home_url('/shop')); ?>"
                            class="inline-block px-10 py-4 bg-gradient-to-r from-[#FF6F00] to-[#FF4500] text-white rounded-xl font-black text-lg hover:shadow-xl hover:shadow-[#FF4500]/40 transition duration-300 transform hover:scale-105">
                            🛍️ START SHOPPING
                        </a>
                    </div>

                    <!-- Featured Products Promo -->
                    <div class="mt-16 p-8 bg-gradient-to-r from-[#FF6F00]/5 to-[#FF4500]/5 rounded-2xl border border-[#FF6F00]/20">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">✨ Don't miss out on our bestsellers!</h3>
                        <p class="text-gray-600 mb-6">Add items to your cart and enjoy fast delivery with satisfaction guarantee.</p>
                        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="text-[#FF6F00] font-black hover:underline">
                            Browse our full collection →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<style>
    /* Smooth animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .max-w-7xl > * {
        animation: slideInUp 0.5s ease-out;
    }
</style>

<?php
do_action('woocommerce_after_cart');
get_footer('shop');
