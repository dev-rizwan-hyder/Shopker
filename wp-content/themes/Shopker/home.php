<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<style>
    .hero-section {
        background-image: url(https://shopker.store/wp-content/uploads/2026/05/ChatGPT-Image-May-9-2026-12_53_37-AM-1.png);
        background-size: cover;
        background-position: center;
        width: 100%
    }
    
   @media (max-width: 768px) {
    .hero-section {
        background-image: url(https://shopker.store/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-09-at-1.26.15-AM-1.jpeg);
        background-size: cover;
        background-position: center;;
        height: 100vh;
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

    /* Remove underline from product prices */
.woocommerce-Price-amount,
.price,
ins,
.woocommerce-Price-amount bdi {
    text-decoration: none !important;
    border-bottom: none !important;
}
</style>

<section class="relative w-full flex items-center overflow-hidden" style="height: 100vh; min-height: 100vh;">
    <div class="hero-section absolute inset-0">
    </div>

    <div class="hero-container relative z-10 w-full max-w-7xl mx-auto">
       
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
    <div class="mx-auto w-full max-w-7xl px-6 md:px-10 pb-16">
        <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <span
                    class="inline-flex rounded-full bg-[#FF4500] px-4 py-1.5 text-[12px] font-black uppercase tracking-wider text-white shadow-lg">
                    Featured Products
                </span>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-black md:text-4xl">
                    Explore Our Latest Products
                </h2>
            </div>

            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                class="inline-flex w-fit items-center rounded-xl border border-[#FF4500] bg-white px-5 py-3 text-sm font-black uppercase tracking-wider text-[#FF4500] transition hover:bg-[#FF4500] hover:text-white">
                View All Products
            </a>
        </div>

            <style>

   @media (max-width: 768px) {
    .mobile-carousel .grid {
        display: flex !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;

        gap: 12px;
        padding-bottom: 10px;

        scroll-behavior: smooth;
    }

    .mobile-carousel .grid > div {
        min-width: 85%;
        flex: 0 0 auto;
    }
}

    .product-grid-image-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        /* Gives the product some breathing room */
    }

    .product-grid-image-container img {
        max-width: 100%;
        max-height: 100%;
        width: auto !important;
        height: auto !important;

        object-fit: cover !important;
        /* mix-blend-multiply ensures transparent images don't look "ghosted" on off-white backgrounds */
        mix-blend-multiply: multiply;
        filter: contrast(1.05);
        /* Makes the product colors pop */
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

        .product-grid-image-container .hover-img {
        position: absolute;
        inset: 0;
        opacity: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: auto;
   }

    .group:hover .product-grid-image-container .main-img {
        opacity: 0;
        transform: scale(1.1);
    }

    .group:hover .product-grid-image-container .hover-img {
        opacity: 1;
        transform: scale(1.1);
    }
</style>

<div class="mobile-carousel">
<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4 place-items-center">
    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 8,
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
    class="group relative flex w-full max-w-[280px] flex-col overflow-hidden rounded-2xl bg-white p-4 shadow-sm transition hover:shadow-2xl border border-gray-100">

                <div class="relative aspect-square overflow-hidden rounded-xl bg-[#ffffff]">
                    <a href="<?php the_permalink(); ?>" class="product-grid-image-container z-10">
                        <?php
                        $image_id = $product->get_image_id();
                        $gallery_ids = $product->get_gallery_image_ids();

                        if ($image_id) {

                            echo wp_get_attachment_image($image_id, 'woocommerce_single', false, array(
                                'class' => 'main-img'
                            ));

                            if (!empty($gallery_ids)) {
                                echo wp_get_attachment_image($gallery_ids[0], 'woocommerce_single', false, array(
                                    'class' => 'hover-img'
                                ));
                            }

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

<div style="height: 80px; background: #f8f8f8;"></div>

</div>
</section>

<?php get_footer(); ?>