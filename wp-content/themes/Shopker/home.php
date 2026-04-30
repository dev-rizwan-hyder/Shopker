<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<section class="relative h-screen w-full flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero.png');">
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/20 to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-8xl mx-auto ml-[150px] px-6 md:px-12">
        <div class="max-w-4xl">
            <div class="inline-block mb-4">
                <span
                    class="bg-[#FF4500] text-white px-4 py-1.5 rounded-full text-[12px] font-black uppercase tracking-wider shadow-lg">
                    ✨ Welcome to Shopker
                </span>
            </div>

            <h1 class="text-5xl md:text-7xl font-black text-white mb-4 leading-[1.1] drop-shadow-md">
                Your Premium <br> Shopping <br> Destination
            </h1>

            <p class="text-lg md:text-xl text-gray-100 mb-8 font-medium max-w-lg leading-relaxed">
                Discover thousands of products with exclusive deals and fast delivery nationwide.
            </p>

            <div class="flex flex-wrap gap-4 mb-8">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                    class="bg-[#FF4500] hover:bg-[#e63e00] text-white px-8 py-4 rounded-xl font-black text-sm uppercase transition transform hover:scale-105 shadow-xl flex items-center gap-2">
                    🛍️ Start Shopping
                </a>
                <a href="#"
                    class="bg-white hover:bg-gray-100 text-black px-8 py-4 rounded-xl font-black text-sm uppercase transition transform hover:scale-105 shadow-xl flex items-center gap-2">
                    📞 Contact Us
                </a>
            </div>

            <div class="inline-flex bg-white px-6 py-3 rounded-xl shadow-2xl border-b-4 border-orange-500">
                <p class="text-[13px] md:text-sm font-black tracking-tight text-gray-800">
                    <span class="text-orange-600">🎁 BUY 2 GET 1 FREE</span>
                    <span class="mx-2 text-gray-300">|</span>
                    <span class="text-orange-600">🚚 FREE DELIVERY ALL OVER PAKISTAN</span>
                </p>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2">
        <div class="animate-bounce">
            <svg class="w-6 h-6 text-white opacity-70" fill="none" stroke="currentColor" stroke-width="3"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

<section class="bg-[#f8f8f8] py-20">
    <div class="mx-auto max-w-7xl px-6 md:px-10">
        <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <span
                    class="inline-flex rounded-full bg-[#FF4500] px-4 py-1.5 text-[12px] font-black uppercase tracking-wider text-white shadow-lg">
                    Featured Products
                </span>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-black md:text-4xl">
                    Explore Our Latest Products
                </h2>
                <p class="mt-3 text-base leading-7 text-gray-600 md:text-lg">
                    A clean product showcase pulled directly from your WooCommerce catalog.
                </p>
            </div>

            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                class="inline-flex w-fit items-center rounded-xl border border-[#FF4500] bg-white px-5 py-3 text-sm font-black uppercase tracking-wider text-[#FF4500] transition hover:bg-[#FF4500] hover:text-white">
                View All Products
            </a>
        </div>

        <style>
            .product-grid-image-container {
                position: relative;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px;
                /* Gives the product some breathing room */
            }

            .product-grid-image-container img {
                max-width: 100%;
                max-height: 100%;
                width: auto !important;
                height: auto !important;
                object-fit: contain !important;
                /* mix-blend-multiply ensures transparent images don't look "ghosted" on off-white backgrounds */
                mix-blend-multiply: multiply;
                filter: contrast(1.05);
                /* Makes the product colors pop */
                transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .group:hover .product-grid-image-container img {
                transform: scale(1.1);
            }
        </style>

        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $products = new WP_Query($args);

            if ($products->have_posts()) {
                while ($products->have_posts()) {
                    $products->the_post();
                    global $product;
                    $product = wc_get_product(get_the_ID());
                    ?>
                    <div
                        class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-4 shadow-sm transition hover:shadow-2xl border border-gray-100">

                        <div class="relative aspect-square overflow-hidden rounded-xl bg-[#ffffff]">
                            <a href="<?php the_permalink(); ?>" class="product-grid-image-container z-10">
                                <?php
                                $image_id = $product->get_image_id();
                                if ($image_id) {
                                    echo wp_get_attachment_image($image_id, 'woocommerce_single', false, array(
                                        'class' => 'main-img'
                                    ));
                                } else {
                                    echo wc_placeholder_img('woocommerce_single');
                                }
                                ?>
                            </a>

                            <?php if ($product->is_on_sale()): ?>
                                <span
                                    class="absolute left-2 top-2 z-20 rounded-lg bg-[#FF4500] px-3 py-1 text-[10px] font-black uppercase text-white shadow-lg">Sale!</span>
                            <?php endif; ?>
                        </div>

                        <div class="mt-4 flex flex-col flex-grow text-center">
                            <h3 class="text-sm font-black uppercase tracking-tight text-gray-900 line-clamp-2 px-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-[#FF4500] transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <div class="mt-2 flex items-center justify-center gap-2">
                                <p class="text-lg font-black text-[#FF4500]">
                                    <?php echo $product->get_price_html(); ?>
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-50">
                                <a href="<?php the_permalink(); ?>"
                                    class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-[#FF4500] transition-colors">
                                    View Product →
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>