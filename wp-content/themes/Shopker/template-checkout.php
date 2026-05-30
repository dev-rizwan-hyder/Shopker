<?php
/**
 * Template Name: Shopker Checkout Page
 * Template Post Type: page
 * Description: Custom checkout page template with Shopker styling
 */

defined('ABSPATH') || exit;

get_header('shop');

do_action('woocommerce_before_checkout_form');
?>

<div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-gray-100">
    <!-- Breadcrumb -->
    <div class="py-4 px-6 md:px-10 max-w-7xl mt-16 mx-auto">
        <nav class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-500">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-[#FF6F00] transition">Home</a>
            <span class="text-gray-300">/</span>
            <a href="<?php echo esc_url(home_url('/cart')); ?>" class="hover:text-[#FF6F00] transition">Cart</a>
            <span class="text-gray-300">/</span>
            <span class="text-[#FF6F00]">Checkout</span>
        </nav>
    </div>

    <section class="pb-20 pt-6">
        <div class="mx-auto max-w-7xl px-6 md:px-10">
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <!-- Security Badge -->
                    <div class="mb-8 p-4 bg-gradient-to-r from-[#FF6F00]/5 to-[#FF4500]/5 border border-[#FF6F00]/20 rounded-xl flex items-center gap-3">
                        <span class="text-2xl">🔒</span>
                        <div>
                            <p class="font-black text-gray-900">Your checkout is 100% secure</p>
                            <p class="text-sm text-gray-600">Your information is encrypted and protected with industry-standard security.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm">
                        <h2 class="text-3xl font-black mb-8 text-gray-900 flex items-center gap-3">
                            <span class="text-4xl">📍</span>
                            Delivery Address
                        </h2>

                        <?php
                        do_action('woocommerce_checkout_before_customer_details');

                        echo do_shortcode('[woocommerce_checkout]');

                        do_action('woocommerce_checkout_after_customer_details');
                        ?>
                    </div>

                    <!-- Support Section -->
                    <div class="mt-8 p-6 bg-white rounded-2xl border border-gray-100">
                        <h3 class="text-lg font-black text-gray-900 mb-4">❓ Need Help?</h3>
                        <p class="text-gray-600 mb-4">Having trouble completing your order?</p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-[#FF6F00] font-black hover:underline">
                            Contact our support team →
                        </a>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1 h-fit lg:sticky lg:top-24">
                    <?php get_template_part('woocommerce/cart-sidebar'); ?>

                    <!-- Trust & Security Info -->
                    <div class="mt-8 p-6 bg-white rounded-2xl border border-gray-100 space-y-5">
                        <div class="flex items-start gap-3">
                            <span class="text-3xl">✅</span>
                            <div>
                                <p class="font-black text-gray-900 text-sm">Verified Seller</p>
                                <p class="text-xs text-gray-600">Trusted by thousands</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-3xl">📦</span>
                            <div>
                                <p class="font-black text-gray-900 text-sm">Free Shipping</p>
                                <p class="text-xs text-gray-600">On all orders</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-3xl">🔄</span>
                            <div>
                                <p class="font-black text-gray-900 text-sm">Easy Returns</p>
                                <p class="text-xs text-gray-600">30-day guarantee</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="mt-8 p-6 bg-gradient-to-br from-[#FF6F00]/5 to-[#FF4500]/5 rounded-2xl border border-[#FF6F00]/20">
                        <h4 class="font-black text-gray-900 mb-3 flex items-center gap-2">
                            💰 Payment Method
                        </h4>
                        <p class="text-sm text-gray-700 font-bold">Cash on Delivery (COD)</p>
                        <p class="text-xs text-gray-600 mt-2">Pay safely when your order arrives. No upfront payment required!</p>
                    </div>
                </div>
            </div>
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

    /* WooCommerce Checkout Form Styling */
    .woocommerce form.checkout {
        background: transparent;
    }

    .woocommerce .form-row {
        margin-bottom: 20px;
    }

    .woocommerce .form-row label {
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }

    .woocommerce .form-row input,
    .woocommerce .form-row textarea,
    .woocommerce .form-row select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        background-color: #fafafa;
    }

    .woocommerce .form-row input:focus,
    .woocommerce .form-row textarea:focus,
    .woocommerce .form-row select:focus {
        outline: none;
        border-color: #FF6F00;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(255, 111, 0, 0.1);
    }

    .woocommerce .form-row.form-row-first,
    .woocommerce .form-row.form-row-last {
        width: 100%;
        float: none;
        margin-right: 0;
    }

    /* Section Titles */
    .woocommerce h3 {
        font-size: 24px;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 3px solid #FF6F00;
        display: inline-block;
    }

    /* Payment Method */
    .woocommerce .payment {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .woocommerce .payment ul li {
        margin-bottom: 15px;
    }

    .woocommerce .payment ul li label {
        font-weight: 900;
        color: #1a1a1a;
        margin-left: 8px;
    }

    .woocommerce .payment ul li input[type="radio"] {
        width: auto;
        margin-right: 10px;
        accent-color: #FF6F00;
    }

    /* Place Order Button */
    .woocommerce #place_order {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #FF6F00 0%, #FF4500 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 20px;
        box-shadow: 0 5px 15px rgba(255, 69, 0, 0.3);
    }

    .woocommerce #place_order:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 69, 0, 0.4);
    }

    .woocommerce #place_order:active {
        transform: translateY(0);
    }

    /* Order Review */
    .woocommerce-checkout-review-order {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .woocommerce table.shop_table th {
        background: #FF6F00;
        color: white;
        font-weight: 900;
        padding: 12px;
        text-align: left;
    }

    .woocommerce table.shop_table tfoot th,
    .woocommerce table.shop_table tfoot td {
        background: white;
        font-weight: 900;
        color: #1a1a1a;
    }

    .woocommerce table.shop_table tfoot tr:last-child th,
    .woocommerce table.shop_table tfoot tr:last-child td {
        background: #FF6F00;
        color: white;
        font-size: 18px;
    }

    .woocommerce .order-total .amount {
        color: #FF4500;
        font-weight: 900;
        font-size: 24px;
    }

    /* Terms Section */
    .woocommerce .woocommerce-terms-and-conditions-checkbox-wrapper {
        margin: 20px 0;
        padding: 16px;
        background: #f9f9f9;
        border-radius: 12px;
    }

    .woocommerce .woocommerce-terms-and-conditions-checkbox-wrapper label {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .woocommerce .woocommerce-terms-and-conditions-checkbox-wrapper input[type="checkbox"] {
        width: auto;
        accent-color: #FF6F00;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .woocommerce .form-row input,
        .woocommerce .form-row textarea,
        .woocommerce .form-row select {
            padding: 10px 12px;
            font-size: 16px;
        }

        .woocommerce #place_order {
            padding: 14px;
            font-size: 16px;
        }
    }
</style>

<?php
do_action('woocommerce_after_checkout_form');
get_footer('shop');
