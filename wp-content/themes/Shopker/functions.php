<?php
/**
 * Shopker Theme Functions
 */

function shopker_theme_setup()
{
    // Enable featured images for your portfolio items
    add_theme_support('post-thumbnails');
    // Let WordPress manage the <title> tag in the head
    add_theme_support('title-tag');
    // Switch default core markup for search form, comment form, etc. to output valid HTML5
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('woocommerce');
    
    // Register navigation menu
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'shopker' ),
    ) );
}
add_action('after_setup_theme', 'shopker_theme_setup');

/**
 * Fallback navigation menu
 */
function shopker_nav_fallback() {
    echo '<ul>';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about-us' ) ) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact-us' ) ) . '">Contact Us</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/privacy-policy' ) ) . '">Privacy Policy</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/reviews' ) ) . '">Reviews</a></li>';
    echo '<li class="promo-item"><a href="#">🎁 BUY 2 GET 1 FREE</a></li>';
    echo '<li class="promo-item"><a href="#">🚚 FREE DELIVERY UPTO 3000RS</a></li>';
    echo '</ul>';
}

function shopker_enqueue_scripts()
{
    // 1. Tailwind (External CDN)
    wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false);

    wp_add_inline_script('tailwind-cdn', "
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        topBarGold: '#8b6e3d',
                        weboGreen: '#00a859',
                        weboBlue: '#0054a6',
                        weboOrange: '#ff6600'
                    },
                    backgroundImage: {
                        'btn-gradient': 'linear-gradient(90deg, #0054a6 0%, #00a859 100%)'
                    }
                }
            }
        };
    ", 'after');

    // 1.1 Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

    // 2. Theme CSS and JS
    $main_css_path = get_template_directory() . '/assets/css/main.css';
    $main_js_path = get_template_directory() . '/assets/js/main.js';
    $style_css_path = get_stylesheet_directory() . '/style.css';

    $main_css_version = file_exists($main_css_path) ? (string) filemtime($main_css_path) : null;
    $main_js_version = file_exists($main_js_path) ? (string) filemtime($main_js_path) : null;
    $style_css_version = file_exists($style_css_path) ? (string) filemtime($style_css_path) : null;

    wp_enqueue_style('theme-main-css', get_template_directory_uri() . '/assets/css/main.css', array(), $main_css_version);
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), null);
    wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1');

    // 3. Main Theme style.css
    wp_enqueue_style('main-styles', get_stylesheet_uri(), array(), $style_css_version);

    // 4. Custom JavaScript
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('swiper-js'), $main_js_version, true);
}
add_action('wp_enqueue_scripts', 'shopker_enqueue_scripts');


/**
 * WooCommerce tiered pricing for Shopker.
 */
function shopker_get_tier_pricing_data( $product_id )
{
    $tiers = get_post_meta( $product_id, '_shopker_tier_pricing', true );

    if ( empty( $tiers ) ) {
        $parent_id = wp_get_post_parent_id( $product_id );

        if ( $parent_id ) {
            $tiers = get_post_meta( $parent_id, '_shopker_tier_pricing', true );
        }
    }

    if ( ! is_array( $tiers ) ) {
        return array();
    }

    $clean_tiers = array();

    foreach ( $tiers as $tier ) {
        $qty   = isset( $tier['qty'] ) ? absint( $tier['qty'] ) : 0;
        $price = isset( $tier['price'] ) ? trim( (string) $tier['price'] ) : '';

        if ( function_exists( 'wc_format_decimal' ) ) {
            $price = wc_format_decimal( $price );
        }

        if ( $qty < 2 || $price === '' ) {
            continue;
        }

        $clean_tiers[ $qty ] = array(
            'qty'   => $qty,
            'price' => (float) $price,
        );
    }

    ksort( $clean_tiers );

    return array_values( $clean_tiers );
}

function shopker_get_applicable_tier_price( $quantity, $tiers )
{
    $applicable_price = null;

    foreach ( $tiers as $tier ) {
        if ( $quantity >= (int) $tier['qty'] ) {
            $applicable_price = (float) $tier['price'];
            continue;
        }

        break;
    }

    return $applicable_price;
}

function shopker_add_tier_pricing_product_data_tab( $tabs )
{
    $tabs['shopker_tier_pricing'] = array(
        'label'    => esc_html__( 'Tier Pricing', 'shopker' ),
        'target'   => 'shopker_tier_pricing_product_data',
        'class'    => array( 'show_if_simple', 'show_if_variable' ),
        'priority' => 90,
    );

    return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'shopker_add_tier_pricing_product_data_tab' );

function shopker_render_tier_pricing_product_data_panel()
{
    global $post;

    $stored_tiers = get_post_meta( $post->ID, '_shopker_tier_pricing', true );
    $tiers        = is_array( $stored_tiers ) && ! empty( $stored_tiers ) ? array_values( $stored_tiers ) : array(
        array(
            'qty'   => '',
            'price' => '',
        ),
    );
    ?>
    <div id="shopker_tier_pricing_product_data" class="panel woocommerce_options_panel hidden">
        <div class="options_group">
            <?php wp_nonce_field( 'shopker_save_tier_pricing', 'shopker_tier_pricing_nonce' ); ?>
            <p class="form-field">
                <strong><?php esc_html_e( 'Quantity-based pricing', 'shopker' ); ?></strong>
            </p>
            <p class="form-field description">
                <?php esc_html_e( 'Set a lower price for buying 2, 3, 4 or more items. Regular WooCommerce price remains the price for 1 item.', 'shopker' ); ?>
            </p>

            <table class="widefat striped" id="shopker-tier-pricing-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'Min quantity', 'shopker' ); ?></th>
                        <th><?php esc_html_e( 'Price per item', 'shopker' ); ?></th>
                        <th><?php esc_html_e( 'Action', 'shopker' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $tiers as $index => $tier ) : ?>
                        <tr>
                            <td>
                                <input type="number" min="2" step="1" name="shopker_tier_pricing[<?php echo esc_attr( $index ); ?>][qty]" value="<?php echo esc_attr( $tier['qty'] ?? '' ); ?>" class="short" placeholder="2" />
                            </td>
                            <td>
                                <input type="text" name="shopker_tier_pricing[<?php echo esc_attr( $index ); ?>][price]" value="<?php echo esc_attr( $tier['price'] ?? '' ); ?>" placeholder="<?php echo esc_attr( function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '' ); ?>" />
                            </td>
                            <td>
                                <button type="button" class="button shopker-remove-tier-row"><?php esc_html_e( 'Remove', 'shopker' ); ?></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p style="margin-top: 12px;">
                <button type="button" class="button button-primary" id="shopker-add-tier-row"><?php esc_html_e( 'Add Tier', 'shopker' ); ?></button>
            </p>

            <script type="text/template" id="shopker-tier-row-template">
                <tr>
                    <td>
                        <input type="number" min="2" step="1" name="shopker_tier_pricing[__INDEX__][qty]" value="" class="short" placeholder="2" />
                    </td>
                    <td>
                        <input type="text" name="shopker_tier_pricing[__INDEX__][price]" value="" placeholder="<?php echo esc_attr( function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '' ); ?>" />
                    </td>
                    <td>
                        <button type="button" class="button shopker-remove-tier-row"><?php esc_html_e( 'Remove', 'shopker' ); ?></button>
                    </td>
                </tr>
            </script>

            <script>
                jQuery(function($) {
                    var tableBody = $('#shopker-tier-pricing-table tbody');
                    var template = $('#shopker-tier-row-template').html();
                    var rowIndex = tableBody.find('tr').length;

                    $('#shopker-add-tier-row').on('click', function() {
                        var html = template.replace(/__INDEX__/g, rowIndex++);
                        tableBody.append(html);
                    });

                    $(document).on('click', '.shopker-remove-tier-row', function() {
                        $(this).closest('tr').remove();
                    });
                });
            </script>
        </div>
    </div>
    <?php
}
add_action( 'woocommerce_product_data_panels', 'shopker_render_tier_pricing_product_data_panel' );

function shopker_save_tier_pricing_product_data( $product )
{
    if ( ! isset( $_POST['shopker_tier_pricing_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['shopker_tier_pricing_nonce'] ), 'shopker_save_tier_pricing' ) ) {
        return;
    }

    if ( empty( $_POST['shopker_tier_pricing'] ) || ! is_array( $_POST['shopker_tier_pricing'] ) ) {
        $product->delete_meta_data( '_shopker_tier_pricing' );
        return;
    }

    $clean_tiers = array();

    foreach ( wp_unslash( $_POST['shopker_tier_pricing'] ) as $tier ) {
        $qty   = isset( $tier['qty'] ) ? absint( $tier['qty'] ) : 0;
        $price = isset( $tier['price'] ) ? trim( (string) $tier['price'] ) : '';

        if ( function_exists( 'wc_format_decimal' ) ) {
            $price = wc_format_decimal( $price );
        }

        if ( $qty < 2 || $price === '' ) {
            continue;
        }

        $clean_tiers[ $qty ] = array(
            'qty'   => $qty,
            'price' => (float) $price,
        );
    }

    ksort( $clean_tiers );

    if ( ! empty( $clean_tiers ) ) {
        $product->update_meta_data( '_shopker_tier_pricing', array_values( $clean_tiers ) );
    } else {
        $product->delete_meta_data( '_shopker_tier_pricing' );
    }
}
add_action( 'woocommerce_admin_process_product_object', 'shopker_save_tier_pricing_product_data' );

function shopker_render_tier_pricing_table()
{
    global $product;

    if ( ! is_a( $product, 'WC_Product' ) || ! $product->is_type( 'simple' ) ) {
        return;
    }

    $tiers = shopker_get_tier_pricing_data( $product->get_id() );

    if ( empty( $tiers ) ) {
        return;
    }

    $base_price = (float) $product->get_price();
    ?>
    <div class="mt-6 rounded-2xl border border-orange-100 bg-white shadow-sm overflow-hidden">
        <div class="bg-orange-50 px-5 py-4 border-b border-orange-100">
            <h3 class="text-lg font-black text-black uppercase tracking-wide mb-1"><?php esc_html_e( 'Bulk Pricing', 'shopker' ); ?></h3>
            <p class="text-sm text-gray-600"><?php esc_html_e( 'Buy more, pay less per item.', 'shopker' ); ?></p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-orange-50/70">
                    <tr>
                        <th class="px-5 py-3 font-bold text-black"><?php esc_html_e( 'Qty', 'shopker' ); ?></th>
                        <th class="px-5 py-3 font-bold text-black"><?php esc_html_e( 'Price / Item', 'shopker' ); ?></th>
                        <th class="px-5 py-3 font-bold text-black"><?php esc_html_e( 'Savings', 'shopker' ); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100">
                    <?php foreach ( $tiers as $tier ) : ?>
                        <?php
                        $item_price    = (float) $tier['price'];
                        $savings_total = max( 0, ( $base_price - $item_price ) * (int) $tier['qty'] );
                        ?>
                        <tr class="bg-white">
                            <td class="px-5 py-3 font-semibold text-gray-900"><?php echo esc_html( $tier['qty'] ); ?>+</td>
                            <td class="px-5 py-3 font-bold text-orange-600"><?php echo wp_kses_post( wc_price( $item_price ) ); ?></td>
                            <td class="px-5 py-3 text-green-600 font-semibold"><?php echo wp_kses_post( wc_price( $savings_total ) ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
add_action( 'woocommerce_single_product_summary', 'shopker_render_tier_pricing_table', 25 );

function shopker_store_base_price_in_cart_item_data( $cart_item_data, $product_id, $variation_id )
{
    if ( ! function_exists( 'wc_get_product' ) ) {
        return $cart_item_data;
    }

    $target_product_id = $variation_id ? $variation_id : $product_id;
    $product           = wc_get_product( $target_product_id );

    if ( $product ) {
        $cart_item_data['shopker_base_price'] = (float) $product->get_price();
    }

    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'shopker_store_base_price_in_cart_item_data', 10, 3 );

function shopker_restore_base_price_from_session( $cart_item, $values )
{
    if ( isset( $values['shopker_base_price'] ) ) {
        $cart_item['shopker_base_price'] = $values['shopker_base_price'];
    }

    return $cart_item;
}
add_filter( 'woocommerce_get_cart_item_from_session', 'shopker_restore_base_price_from_session', 10, 2 );

function shopker_apply_tier_pricing_to_cart( $cart )
{
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    if ( ! is_a( $cart, 'WC_Cart' ) ) {
        return;
    }

    foreach ( $cart->get_cart() as $cart_item ) {
        if ( empty( $cart_item['data'] ) || ! is_a( $cart_item['data'], 'WC_Product' ) ) {
            continue;
        }

        $product_id = ! empty( $cart_item['variation_id'] ) ? (int) $cart_item['variation_id'] : (int) $cart_item['product_id'];
        $tiers      = shopker_get_tier_pricing_data( $product_id );

        if ( empty( $tiers ) ) {
            continue;
        }

        $quantity   = isset( $cart_item['quantity'] ) ? (int) $cart_item['quantity'] : 1;
        $base_price = isset( $cart_item['shopker_base_price'] ) ? (float) $cart_item['shopker_base_price'] : (float) $cart_item['data']->get_price();
        $tier_price = shopker_get_applicable_tier_price( $quantity, $tiers );

        if ( null !== $tier_price ) {
            $cart_item['data']->set_price( min( $base_price, (float) $tier_price ) );
        } else {
            $cart_item['data']->set_price( $base_price );
        }
    }
}
add_action( 'woocommerce_before_calculate_totals', 'shopker_apply_tier_pricing_to_cart', 20 );

function shopker_get_product_image_html( $product, $size = 'woocommerce_thumbnail' )
{
    if ( is_numeric( $product ) ) {
        $product = function_exists( 'wc_get_product' ) ? wc_get_product( (int) $product ) : null;
    }

    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
        if ( function_exists( 'wc_placeholder_img' ) ) {
            return wc_placeholder_img( $size );
        }
        return '<div class="flex h-full w-full items-center justify-center bg-orange-50 text-6xl text-orange-200">🛍️</div>';
    }

    $image_id = (int) $product->get_image_id();

    if ( $image_id > 0 ) {
        $image_src = wp_get_attachment_image_src( $image_id, $size );
        if ( $image_src && ! empty( $image_src[0] ) ) {
            return '<img src="' . esc_url( $image_src[0] ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="eager" decoding="async" />';
        }
    }

    $gallery_ids = $product->get_gallery_image_ids();
    if ( ! empty( $gallery_ids ) && is_array( $gallery_ids ) ) {
        foreach ( $gallery_ids as $gallery_id ) {
            $gallery_image = wp_get_attachment_image_src( $gallery_id, $size );
            if ( $gallery_image && ! empty( $gallery_image[0] ) ) {
                return '<img src="' . esc_url( $gallery_image[0] ) . '" alt="' . esc_attr( $product->get_name() ) . '" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="eager" decoding="async" />';
            }
        }
    }

    if ( function_exists( 'wc_placeholder_img' ) ) {
        return wc_placeholder_img( $size );
    }

    return '<div class="flex h-full w-full items-center justify-center bg-orange-50 text-6xl text-orange-200">🛍️</div>';
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'shopker_custom_cart_button_text' ); 
function shopker_custom_cart_button_text() {
    return __( 'Order Now with Discount', 'woocommerce' ); 
}

/**
 * 2. Redirect to Checkout immediately when "Buy It Now" is clicked
 * This looks for the 'checkout' parameter in the URL.
 */
add_filter('woocommerce_add_to_cart_redirect', 'shopker_skip_cart_redirect');
function shopker_skip_cart_redirect($url) {
    if (isset($_REQUEST['checkout'])) {
        return wc_get_checkout_url();
    }
    return $url;
}

add_action('wp_footer', 'shopker_pack_selector_script');
function shopker_pack_selector_script() {
    if ( ! is_product() ) return;
    ?>
    <script>
    function buyNowWithPack() {
        const form = document.querySelector('form.cart');
        if (!form) return;

        // Create a hidden input to trigger the checkout redirect
        const checkoutInput = document.createElement('input');
        checkoutInput.type = 'hidden';
        checkoutInput.name = 'checkout';
        checkoutInput.value = 'true';
        form.appendChild(checkoutInput);

        // Find the actual WooCommerce Add to Cart button and click it
        const submitBtn = form.querySelector('.single_add_to_cart_button');
        if (submitBtn) {
            submitBtn.click();
        }
    }
    </script>
    <?php
}

/**
 * Enable Cash on Delivery Payment Method
 */
add_filter('woocommerce_payment_gateways', 'shopker_register_cod_gateway');
function shopker_register_cod_gateway($gateways) {
    $gateways[] = 'WC_Gateway_COD';
    return $gateways;
}

/**
 * Filter available payment methods at checkout - Only show COD
 */
add_filter('woocommerce_available_payment_gateways', 'shopker_filter_payment_gateways');
function shopker_filter_payment_gateways($available_gateways) {
    // Only keep COD if it exists
    if (isset($available_gateways['cod'])) {
        return array('cod' => $available_gateways['cod']);
    }
    
    // Fallback: return all if COD not available
    return $available_gateways;
}

/**
 * Customize COD gateway title and description
 */
add_filter('woocommerce_gateway_title', 'shopker_customize_cod_title', 10, 2);
function shopker_customize_cod_title($title, $id) {
    if ($id === 'cod') {
        return '💰 Cash on Delivery (COD)';
    }
    return $title;
}

add_filter('woocommerce_gateway_description', 'shopker_customize_cod_description', 10, 2);
function shopker_customize_cod_description($description, $id) {
    if ($id === 'cod') {
        return 'Pay safely when your order is delivered. No online payment required.';
    }
    return $description;
}

/**
 * Customize order received/thank you page for COD
 */
add_filter('woocommerce_thankyou_order_received_text', 'shopker_thankyou_message', 10, 2);
function shopker_thankyou_message($message, $order) {
    if ($order && $order->get_payment_method() === 'cod') {
        return '✅ Thank you! Your order has been confirmed. Our team will contact you shortly to confirm delivery details.';
    }
    return $message;
}

/**
 * Add custom order status message after order placed
 */
add_action('woocommerce_thankyou', 'shopker_thankyou_custom_message', 5);
function shopker_thankyou_custom_message($order_id) {
    $order = wc_get_order($order_id);
    if ($order && $order->get_payment_method() === 'cod') {
        echo '<div class="woocommerce-info" style="background: #d4edda; border-color: #c3e6cb; color: #155724; padding: 20px; border-radius: 10px; margin: 20px 0; font-weight: bold;">';
        echo '✅ <strong>Order Confirmed!</strong><br>';
        echo 'Payment method: <strong>Cash on Delivery</strong><br>';
        echo 'You will receive a call from our team to confirm your delivery address and timeline.<br>';
        echo 'Expected delivery: Within 1-2 business days';
        echo '</div>';
    }
}

/**
 * AJAX handler to get cart contents for sidebar
 */
add_action('wp_ajax_wc_get_cart_contents', 'shopker_ajax_get_cart_contents');
add_action('wp_ajax_nopriv_wc_get_cart_contents', 'shopker_ajax_get_cart_contents');
function shopker_ajax_get_cart_contents() {
    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json(array('cart_contents' => array()));
        return;
    }

    $cart_items = array();
    $cart = WC()->cart;

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        
        if ($_product) {
            $image_id = $_product->get_image_id();
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : wc_placeholder_img_src();

            $cart_items[] = array(
                'product_id' => $_product->get_id(),
                'product_name' => $_product->get_name(),
                'quantity' => $cart_item['quantity'],
                'line_total' => $cart_item['line_total'],
                'product_image' => $image_url,
            );
        }
    }

    wp_send_json(array('cart_contents' => $cart_items));
}

/**
 * Create custom orders table on theme activation
 */
function shopker_create_orders_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'shopker_orders';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        order_id bigint(20) NOT NULL,
        customer_name varchar(255) NOT NULL,
        customer_email varchar(255) NOT NULL,
        customer_phone varchar(20) NOT NULL,
        shipping_address text NOT NULL,
        city varchar(100) NOT NULL,
        state varchar(100) NOT NULL,
        postal_code varchar(20) NOT NULL,
        order_total decimal(10, 2) NOT NULL,
        items_count int(11) NOT NULL,
        payment_method varchar(100) NOT NULL,
        order_status varchar(50) DEFAULT 'pending',
        special_instructions text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY order_id (order_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'shopker_create_orders_table');

/**
 * Store order details in custom table when order is created
 */
function shopker_store_order_details($order_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'shopker_orders';
    
    $order = wc_get_order($order_id);
    
    if (!$order) {
        return;
    }

    $wpdb->insert(
        $table_name,
        array(
            'order_id' => $order_id,
            'customer_name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
            'customer_email' => $order->get_billing_email(),
            'customer_phone' => $order->get_billing_phone(),
            'shipping_address' => $order->get_billing_address_1() . ' ' . $order->get_billing_address_2(),
            'city' => $order->get_billing_city(),
            'state' => $order->get_billing_state(),
            'postal_code' => $order->get_billing_postcode(),
            'order_total' => $order->get_total(),
            'items_count' => $order->get_item_count(),
            'payment_method' => $order->get_payment_method_title(),
            'order_status' => $order->get_status(),
            'special_instructions' => $order->get_customer_note(),
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%d', '%s', '%s', '%s')
    );
}
add_action('woocommerce_new_order', 'shopker_store_order_details');

/**
 * Update order status in custom table
 */
function shopker_update_order_status($order_id, $old_status, $new_status) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'shopker_orders';
    
    $wpdb->update(
        $table_name,
        array('order_status' => $new_status),
        array('order_id' => $order_id),
        array('%s'),
        array('%d')
    );
}
add_action('woocommerce_order_status_changed', 'shopker_update_order_status', 10, 3);

/**
 * Customize checkout fields
 */
function shopker_customize_checkout_fields($fields) {
    // Add class to all fields for better styling
    foreach ($fields as $fieldset) {
        foreach ($fieldset as $field) {
            if (isset($field)) {
                $field['class'] = array('form-row-wide');
                $field['input_class'] = array('input-text');
            }
        }
    }
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'shopker_customize_checkout_fields');

add_action('woocommerce_checkout_order_processed', 'shopker_force_checkout_redirect', 10, 3);
function shopker_force_checkout_redirect($order_id, $posted_data, $order) {
    // If it's an AJAX request (standard WC checkout), WC handles it.
    // If it's a standard POST, we force it.
    if (!wp_doing_ajax()) {
        $url = $order->get_checkout_order_received_url();
        wp_redirect($url);
        exit;
    }
}