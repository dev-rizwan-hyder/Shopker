<?php
defined( 'ABSPATH' ) || exit;

get_header('shop');

global $wp_query;

$is_shop_page = function_exists( 'is_shop' ) && is_shop();
$is_product_tax_archive = function_exists( 'is_product_taxonomy' ) && is_product_taxonomy();
$current_object = get_queried_object() ?: null;

if ( $is_shop_page ) {
    $archive_heading =esc_html__( 'All Products', 'shopker' );
    $archive_subtitle = __( 'Browse the full Shopker catalog with custom pricing, fast browsing, and a polished shopping experience.', 'shopker' );
} elseif ( $is_product_tax_archive && ! empty( $current_object->name ) ) {
    $archive_heading = $current_object->name;
    $archive_subtitle = __( 'Explore products in this collection and pick the best match for your store.', 'shopker' );
} else {
    $archive_heading = __( 'All Products', 'shopker' );
    $archive_subtitle = __( 'Explore the complete product collection from Shopker.', 'shopker' );
}

$product_count = isset( $wp_query->found_posts ) ? absint( $wp_query->found_posts ) : 0;
$categories    = get_terms(
    array(
        'taxonomy'   => 'product_cat',
        'hide_empty'  => true,
        'orderby'     => 'name',
        'order'       => 'ASC',
        'number'      => 12,
    )
);
$current_term_id = ( $is_product_tax_archive && ! empty( $current_object->term_id ) ) ? absint( $current_object->term_id ) : 0;
$shop_url        = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$category_count   = is_array( $categories ) ? count( $categories ) : 0;
$featured_count   = $product_count > 0 ? min( $product_count, 24 ) : 0;
?>
<style>
 /* Remove underline from product prices */
.woocommerce-Price-amount,
.price,
ins,
.woocommerce-Price-amount bdi {
    text-decoration: none !important;
    border-bottom: none !important;
}

    .shopker-ordering {
        width: 100%;
    }

    .shopker-ordering .woocommerce-ordering {
        margin: 0;
        width: 100%;
    }

    .shopker-ordering .orderby {
        width: 100%;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border-radius: 1rem;
        border: 1px solid #fed7aa;
        padding: 0.95rem 1rem;
        background: #ffffff;
        font-weight: 700;
        color: #111827;
        outline: none;
    }

    .shopker-ordering .orderby:focus {
        border-color: #ea580c;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
    }

    .shopker-hover-image img{
    transition:all 0.5s ease;
}

.shopker-hover-image:hover .hover-product-image{
    opacity:1;
    transform:scale(1.05);
}

.shopker-hover-image:hover .main-product-image{
    opacity:0;
    transform:scale(1.05);
}

</style>

<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <?php woocommerce_output_all_notices(); ?>

<!-- SHOP BANNER -->
<section class="mb-10 overflow-hidden rounded-3xl relative md:min-h-[400px] min-h-[320px]">

    <!-- Desktop Image -->
    <div class="absolute inset-0 hidden md:block">
        <img src="https://shopker.store/wp-content/uploads/2026/05/abid-2.png"
             class="w-full h-full object-cover">
    </div>

    <!-- Mobile Image -->
    <div class="absolute inset-0 block md:hidden">
        <img src="https://shopker.store/wp-content/uploads/2026/05/digi-1.png"
             class="w-full h-full object-cover">
    </div>

</section>

    <div class="mt-6 flex flex-wrap gap-3 overflow-x-auto pb-1">
        <a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-bold transition <?php echo $is_shop_page ? 'border-orange-600 bg-orange-600 text-white' : 'border-orange-100 bg-white text-gray-700 hover:border-orange-300 hover:text-orange-600'; ?>">
            All Products
        </a>
    </div>

    <div class="mt-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="mt-2 text-2xl font-black text-gray-900">
                <?php echo esc_html( sprintf( _n( '%s product found', '%s products found', $product_count, 'shopker' ), number_format_i18n( $product_count ) ) ); ?>
            </p>
        </div>
        <div class="max-w-xl rounded-2xl border border-orange-100 bg-orange-50 px-5 py-4 text-sm font-semibold text-gray-700 shadow-sm">
            Buy 2, 3, or more and lower the price per item with your custom tier pricing setup.
        </div>
    </div>

    <?php if ( have_posts() ) : ?>
        <div id="products" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 lg:grid-cols-3 xl:grid-cols-4">
            <?php
            while ( have_posts() ) :
                the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            ?>
        </div>

        <div class="mt-12">
            <?php woocommerce_pagination(); ?>
        </div>
    <?php else : ?>
        <div class="mt-10 rounded-3xl border border-dashed border-orange-200 bg-white px-8 py-14 text-center shadow-sm">
            <p class="text-sm font-bold uppercase tracking-[0.3em] text-orange-600">No products yet</p>
            <h2 class="mt-4 text-3xl font-black text-gray-900"><?php esc_html_e( 'No products were found.', 'shopker' ); ?></h2>
            <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                <?php esc_html_e( 'Add products from the WooCommerce product section to start populating this page.', 'shopker' ); ?>
            </p>
        </div>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
