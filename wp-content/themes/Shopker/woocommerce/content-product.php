<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! is_a( $product, 'WC_Product' ) || ! $product->is_visible() ) {
    return;
}

$product_id       = $product->get_id();
$tier_pricing     = function_exists( 'shopker_get_tier_pricing_data' ) ? shopker_get_tier_pricing_data( $product_id ) : array();
$has_tier_pricing = ! empty( $tier_pricing );
$categories       = get_the_terms( $product_id, 'product_cat' );
$primary_category = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0]->name : __( 'Product', 'shopker' );
$average_rating   = (float) $product->get_average_rating();
$review_count     = (int) $product->get_review_count();
$is_purchasable   = $product->is_purchasable() && $product->is_in_stock();
$button_url       = $product->add_to_cart_url();
$button_text      = $product->add_to_cart_text();
$button_classes   = 'inline-flex flex-1 items-center justify-center rounded-xl px-4 py-3 text-sm font-bold transition';
$button_attrs     = '';

if ( $product->is_type( 'simple' ) && $is_purchasable ) {
    $button_classes .= ' bg-orange-600 text-white hover:bg-orange-700 ajax_add_to_cart add_to_cart_button';
    $button_attrs = sprintf(
        ' data-product_id="%d" data-product_sku="%s" data-quantity="1" rel="nofollow"',
        absint( $product_id ),
        esc_attr( $product->get_sku() )
    );
} else {
    $button_classes .= ' bg-orange-50 text-orange-700 hover:bg-orange-100';
}

$stock_label = $product->is_in_stock() ? __( 'In Stock', 'shopker' ) : __( 'Out of Stock', 'shopker' );
$stock_classes = $product->is_in_stock() ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700';
?>
<article <?php post_class( 'group flex h-full flex-col overflow-hidden rounded-3xl border border-orange-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-2xl' ); ?>>
    <div class="relative bg-gradient-to-br from-orange-50 to-white">
        <a href="<?php the_permalink(); ?>" class="block aspect-square overflow-hidden">
            <?php
            if ( function_exists( 'wc_get_product' ) && $product ) {
                echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail' ) );
            } elseif ( function_exists( 'wc_placeholder_img' ) ) {
                echo wp_kses_post( wc_placeholder_img( 'woocommerce_thumbnail' ) );
            } else {
                echo '<div class="flex h-full w-full items-center justify-center bg-orange-50 text-6xl text-orange-200">🛍️</div>';
            }
            ?>
        </a>

        <div class="absolute left-4 top-4 flex flex-col gap-2">
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="inline-flex items-center rounded-full bg-orange-600 px-3 py-1 text-xs font-black uppercase tracking-widest text-white shadow">
                    Sale
                </span>
            <?php endif; ?>

            <?php if ( $has_tier_pricing ) : ?>
                <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-black uppercase tracking-widest text-emerald-700 shadow">
                    Bulk Pricing
                </span>
            <?php endif; ?>
        </div>

        <div class="absolute right-4 top-4">
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-black uppercase tracking-widest shadow <?php echo esc_attr( $stock_classes ); ?>">
                <?php echo esc_html( $stock_label ); ?>
            </span>
        </div>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-gray-400">
            <?php echo esc_html( $primary_category ); ?>
        </p>

        <h2 class="mt-3 min-h-[3.5rem] text-lg font-black leading-snug text-gray-900">
            <a href="<?php the_permalink(); ?>" class="transition hover:text-orange-600">
                <?php the_title(); ?>
            </a>
        </h2>

        <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
            <div class="flex items-center gap-0.5 text-yellow-400" aria-hidden="true">
                <?php for ( $star = 1; $star <= 5; $star++ ) : ?>
                    <span class="<?php echo esc_attr( $star <= (int) round( $average_rating ) ? 'text-yellow-400' : 'text-gray-200' ); ?>">★</span>
                <?php endfor; ?>
            </div>
            <span class="font-semibold text-gray-700"><?php echo esc_html( number_format_i18n( $average_rating, 1 ) ); ?>/5</span>
            <span>(<?php echo esc_html( $review_count ); ?>)</span>
        </div>

        <div class="mt-4 flex items-end justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Price</p>
                <div class="text-2xl font-black text-orange-600">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>
            </div>

            <?php if ( $has_tier_pricing ) : ?>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                    Qty 2+ cheaper
                </span>
            <?php endif; ?>
        </div>

        <div class="mt-5 flex gap-3">
            <a href="<?php echo esc_url( $button_url ); ?>" class="<?php echo esc_attr( $button_classes ); ?>"<?php echo $button_attrs; ?>>
                <?php echo esc_html( $button_text ); ?>
            </a>

            <a href="<?php the_permalink(); ?>" class="inline-flex items-center justify-center rounded-xl border border-orange-100 px-4 py-3 text-sm font-bold text-gray-700 transition hover:border-orange-600 hover:text-orange-600">
                Details
            </a>
        </div>
    </div>
</article>
