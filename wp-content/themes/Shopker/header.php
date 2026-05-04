<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="relative">
    <!-- Promotional Banner Slider -->
    <div class="promo-slider-container">
        <div class="promo-slider-wrapper">
            <div class="promo-slide">
                🎁 BUY 2 GET 1 FREE
            </div>
            <div class="promo-slide">
                🚚 FREE DELIVERY ALL OVER PAKISTAN
            </div>
        </div>
        <div class="promo-indicators">
            <span class="indicator-dot active"></span>
            <span class="indicator-dot"></span>
        </div>
    </div>

    <!-- Main Header -->
    <div class="bg-white shadow-sm">
        <div class="flex items-center justify-between px-4 sm:px-6 lg:px-10 py-3 sm:py-4 gap-2 sm:gap-4">
            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center flex-shrink-0 hover:opacity-80 transition">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/shopker.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="shopker-logo">
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="desktop-nav hidden lg:flex gap-8 flex-1 justify-center">
                <ul class="flex gap-8 list-none m-0 p-0 items-center">
                    <li><a href="#" class="text-black text-xs xl:text-sm font-bold uppercase hover:text-orange-600 transition whitespace-nowrap">BIG SALES</a></li>
                    <li><a href="#" class="text-black text-xs xl:text-sm font-bold uppercase hover:text-orange-600 transition whitespace-nowrap">NEW ARRIVALS</a></li>
                    <li><a href="#" class="text-black text-xs xl:text-sm font-bold uppercase hover:text-orange-600 transition whitespace-nowrap">CUTE KEYCHAINS</a></li>
                    <li><a href="#" class="text-black text-xs xl:text-sm font-bold uppercase hover:text-orange-600 transition whitespace-nowrap">SHINCHAN KEYCHAIN</a></li>
                    <li><a href="#" class="text-black text-xs xl:text-sm font-bold uppercase hover:text-orange-600 transition whitespace-nowrap">CROSSBODY BAGS</a></li>
                    <li><a href="#" class="text-black text-xs xl:text-sm font-bold uppercase hover:text-orange-600 transition whitespace-nowrap">CONTACT US</a></li>
                </ul>
            </nav>

            <!-- Promotional Pill Buttons Desktop -->
            <div class="promo-buttons hidden 2xl:flex gap-2 flex-shrink-0">
                <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-3 xl:px-5 py-2 rounded-full text-xs font-bold uppercase transition transform hover:scale-105 whitespace-nowrap">
                    🎁 BUY 2 GET 1 FREE
                </a>
                <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-3 xl:px-5 py-2 rounded-full text-xs font-bold uppercase transition transform hover:scale-105 whitespace-nowrap">
                    🚚 FREE DELIVERY
                </a>
            </div>

            <!-- Header Icons (Search & Cart) -->
            <div class="header-icons flex gap-4 items-center flex-shrink-0">
                <svg class="w-6 h-6 stroke-black hover:stroke-orange-600 cursor-pointer transition" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                
                <!-- Cart Icon with Badge -->
                <div class="relative">
                    <svg id="shopker-cart-icon" class="w-6 h-6 stroke-black hover:stroke-orange-600 cursor-pointer transition" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <!-- Cart Badge Counter -->
                    <span id="shopker-cart-count" class="absolute -top-2 -right-2 bg-orange-600 text-white text-xs font-black rounded-full w-5 h-5 flex items-center justify-center" style="display: none;">0</span>
                </div>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button id="mobile-menu-toggle" class="mobile-menu-toggle lg:hidden flex-shrink-0 ml-3">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <nav id="mobile-nav" class="mobile-nav">
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"></a></li>
                <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">SHOP</a></li>
                <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">ABOUT US</a></li>
                <li><a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">CONTACT US</a></li>
                <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">PRIVACY & POLICY</a></li>
                <li><a href="<?php echo esc_url( home_url( '/reviews' ) ); ?>">REVIEWS</a></li>
                <li style="border-bottom: none;"><div class="promo-buttons-mobile hidden gap-2 flex-col p-4">
                    <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-full text-sm font-bold uppercase text-center transition">
                        🎁 BUY 2 GET 1 FREE
                    </a>
                    <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-full text-sm font-bold uppercase text-center transition">
                        🚚 FREE DELIVERY ALL OVER PAKISTAN
                    </a>
                </div></li>
            </ul>
        </nav>
    </div>
</header>