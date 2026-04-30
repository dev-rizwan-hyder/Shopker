<?php
defined( 'ABSPATH' ) || exit;

get_header();

global $wp_query;

$is_shop_page = function_exists( 'is_shop' ) && is_shop();
$is_product_tax_archive = function_exists( 'is_product_taxonomy' ) && is_product_taxonomy();
$current_object = get_queried_object();

if ( $is_shop_page ) {
    $archive_heading = __( 'All Products', 'shopker' );
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
</style>

<section class="relative overflow-hidden bg-gradient-to-br from-black via-neutral-900 to-orange-600 text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_35%)]"></div>
    <div class="absolute -right-16 top-10 h-64 w-64 rounded-full bg-orange-400/25 blur-3xl"></div>
    <div class="absolute -left-20 bottom-0 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <div class="max-w-4xl">
            <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-black uppercase tracking-[0.3em]">
                Shopker Products
            </span>

            <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl">
                <?php echo esc_html( $archive_heading ); ?>
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-7 text-white/80 sm:text-lg">
                <?php echo esc_html( $archive_subtitle ); ?>
            </p>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div class="rounded-3xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-white/70">Products</p>
                <p class="mt-2 text-3xl font-black"><?php echo esc_html( number_format_i18n( $product_count ) ); ?></p>
            </div>
            <div class="rounded-3xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-white/70">Categories</p>
                <p class="mt-2 text-3xl font-black"><?php echo esc_html( number_format_i18n( $category_count ) ); ?></p>
            </div>
            <div class="rounded-3xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-white/70">Featured</p>
                <p class="mt-2 text-3xl font-black"><?php echo esc_html( number_format_i18n( $featured_count ) ); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <?php woocommerce_output_all_notices(); ?>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-3xl border border-orange-100 bg-white p-5 shadow-sm">
            <form role="search" method="get" class="flex flex-col gap-3 md:flex-row" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input
                    type="search"
                    name="s"
                    value="<?php echo esc_attr( get_search_query() ); ?>"
                    placeholder="<?php esc_attr_e( 'Search products, brands, or categories...', 'shopker' ); ?>"
                    class="w-full rounded-2xl border border-orange-100 px-5 py-4 text-base font-medium text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                >
                <input type="hidden" name="post_type" value="product">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-orange-600 px-6 py-4 text-sm font-black uppercase tracking-wider text-white transition hover:bg-orange-700">
                    Search
                </button>
            </form>
        </div>

        <div class="rounded-3xl border border-orange-100 bg-white p-5 shadow-sm">
            <div class="mb-3 text-xs font-bold uppercase tracking-[0.3em] text-gray-500">Sort Products</div>
            <div class="shopker-ordering">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3 overflow-x-auto pb-1">
        <a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-bold transition <?php echo $is_shop_page ? 'border-orange-600 bg-orange-600 text-white' : 'border-orange-100 bg-white text-gray-700 hover:border-orange-300 hover:text-orange-600'; ?>">
            All Products
        </a>

        <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
            <?php foreach ( $categories as $term ) : ?>
                <?php
                $term_link = get_term_link( $term );

                if ( is_wp_error( $term_link ) ) {
                    continue;
                }

                $is_active_term = ( $current_term_id === absint( $term->term_id ) );
                ?>
                <a href="<?php echo esc_url( $term_link ); ?>" class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-bold transition <?php echo $is_active_term ? 'border-orange-600 bg-orange-600 text-white' : 'border-orange-100 bg-white text-gray-700 hover:border-orange-300 hover:text-orange-600'; ?>">
                    <?php echo esc_html( $term->name ); ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="mt-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-orange-600">Collection results</p>
            <p class="mt-2 text-2xl font-black text-gray-900">
                <?php echo esc_html( sprintf( _n( '%s product found', '%s products found', $product_count, 'shopker' ), number_format_i18n( $product_count ) ) ); ?>
            </p>
        </div>
        <div class="max-w-xl rounded-2xl border border-orange-100 bg-orange-50 px-5 py-4 text-sm font-semibold text-gray-700 shadow-sm">
            Buy 2, 3, or more and lower the price per item with your custom tier pricing setup.
        </div>
    </div>

    <?php if ( have_posts() ) : ?>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
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
