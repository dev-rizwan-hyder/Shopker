<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<style>
    .hero-section {
        background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero.png');
        background-size: cover;
        background-position: center;
    }
    
    @media (max-width: 768px) {
        .hero-section {
            background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/mobile_hero.png');
        }
    }

    /* Hero section responsive styles */
    .hero-container {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    @media (min-width: 640px) {
        .hero-container {
            padding-left: 3rem;
            padding-right: 3rem;
            margin-left: 80px;
            max-height: 300px;
        }
    }

    @media (min-width: 1024px) {
        .hero-container {
            margin-left: 150px;
        }
    }

    /* Responsive heading sizes */
    .hero-heading {
        font-size: 2rem; /* Default small screens */
        line-height: 1.1;
    }

    @media (min-width: 640px) {
        .hero-heading {
            font-size: 3rem;
        }
    }

    @media (min-width: 768px) {
        .hero-heading {
            font-size: 3.75rem;
        }
    }

    @media (min-width: 1024px) {
        .hero-heading {
            font-size: 4.5rem;
        }
    }

    /* Responsive paragraph */
    .hero-paragraph {
        font-size: 1rem;
        line-height: 1.6;
    }

    @media (min-width: 768px) {
        .hero-paragraph {
            font-size: 1.125rem;
        }
    }

    /* Responsive buttons */
    .hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        flex-direction: column;
    }

    @media (min-width: 640px) {
        .hero-buttons {
            flex-direction: row;
            gap: 1rem;
        }
    }

    .hero-button {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
    }

    @media (min-width: 768px) {
        .hero-button {
            padding: 1rem 2rem;
        }
    }

    /* Responsive badge */
    .hero-badge {
        font-size: 0.75rem;
        padding: 0.375rem 1rem;
    }

    @media (min-width: 768px) {
        .hero-badge {
            padding: 0.5rem 1rem;
        }
    }

    /* Responsive promo box */
    .hero-promo-box {
        font-size: 0.75rem;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: -200px;
    }

    @media (min-width: 640px) {
        .hero-promo-box {
            font-size: 0.875rem;
            flex-direction: row;
            gap: 0
        }
    }

    @media (min-width: 768px) {
        .hero-promo-box {
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
        }
    }

    /* Arrow animation */
    .hero-arrow {
        bottom: 2rem;
    }

    @media (min-width: 768px) {
        .hero-arrow {
            bottom: 2.5rem;
        }
    }
</style>

<section class="relative w-full flex items-center overflow-hidden" style="height: 100vh; min-height: 100vh;">
    <div class="hero-section absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>
    </div>

    <div class="hero-container relative z-10 w-full max-w-7xl mx-auto">
        <div class="max-w-2xl">
            <div class="inline-block mb-3 sm:mb-4">
                <span class="hero-badge bg-[#FF4500] text-white rounded-full font-black uppercase tracking-wider shadow-lg inline-block">
                    ✨ Welcome to Shopker
                </span>
            </div>

            <h1 class="hero-heading font-black text-white mb-3 sm:mb-4 drop-shadow-md">
                Your Premium Shopping Destination
            </h1>

            <p class="hero-paragraph text-gray-100 mb-6 sm:mb-8 font-medium max-w-lg leading-relaxed">
                Discover thousands of products with exclusive deals and fast delivery nationwide.
            </p>

            <div class="hero-buttons mb-6 sm:mb-8">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                    class="hero-button bg-[#FF4500] hover:bg-[#e63e00] text-white rounded-lg sm:rounded-xl font-black uppercase transition transform hover:scale-105 shadow-xl inline-flex items-center justify-center gap-2 whitespace-nowrap">
                    🛍️ <span>Start Shopping</span>
                </a>
                <a href="#"
                    class="hero-button bg-white hover:bg-gray-100 text-black rounded-lg sm:rounded-xl font-black uppercase transition transform hover:scale-105 shadow-xl inline-flex items-center justify-center gap-2 whitespace-nowrap">
                    📞 <span>Contact Us</span>
                </a>
            </div>

            <div class="hero-promo-box inline-flex bg-white rounded-lg sm:rounded-xl shadow-2xl border-b-4 border-orange-500">
                <p class="font-black tracking-tight text-gray-800">
                    <span class="text-orange-600">🎁 BUY 2 GET 1 FREE</span>
                    <span class="mx-1 sm:mx-2 text-gray-300">|</span>
                    <span class="text-orange-600">🚚 FREE DELIVERY</span>
                </p>
            </div>
        </div>
    </div>

    <div class="hero-arrow absolute left-1/2 -translate-x-1/2">
        <div class="animate-bounce">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white opacity-70" fill="none" stroke="currentColor" stroke-width="3"
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