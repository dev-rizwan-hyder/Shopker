<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
        body, html {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<script>
// Handle cart icon click to open sidebar
document.addEventListener('DOMContentLoaded', function() {
    const cartIcon = document.getElementById('shopker-cart-icon');
    if (cartIcon) {
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            // Call global function from footer
            if (typeof openCartSidebar === 'function') {
                openCartSidebar();
            }
        });
    }

    // Update cart count badge
    function updateCartCount() {
        const countBadge = document.getElementById('shopker-cart-count');
        
        // Fetch count via AJAX
        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>?action=wc_get_cart_contents', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.cart_contents) {
                const count = data.cart_contents.length;
                countBadge.textContent = count;
                countBadge.style.display = count > 0 ? 'flex' : 'none';
            }
        })
        .catch(err => {
            console.log('Cart count error:', err);
        });
    }

    // Initial load
    updateCartCount();

    // Listen for cart updates
    document.addEventListener('wc_cart_updated', updateCartCount);
    
    // Also listen for custom cart update event
    document.addEventListener('shopker_cart_updated', updateCartCount);
});
</script>

<header id="site-header" class="m-0 p-0">
    <!-- Top Bar with Promotional Message -->
    <div class="bg-orange-600 text-white text-center py-3 px-4 font-bold text-sm uppercase tracking-wider">
        🎁 BUY 2 GET 1 FREE
    </div>

    <!-- Main Header -->
    <div class="bg-white shadow-sm py-4 px-5 md:px-10">
        <div class="flex items-center justify-between gap-6">
            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center text-4xl font-black tracking-tighter hover:opacity-80 transition">
                Shop<span class="text-orange-600">ker</span>
            </a>

            <!-- Navigation and Buttons Container -->
            <div class="flex items-center gap-4 flex-1 justify-end">
                <!-- Navigation Menu -->
                <nav class="hidden lg:block gap-6">
                    <ul class="flex gap-12 list-none mr-[150px] p-0">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-black text-sm font-bold uppercase hover:text-orange-600 transition">HOME</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="text-black text-sm font-bold uppercase hover:text-orange-600 transition">SHOP</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>" class="text-black text-sm font-bold uppercase hover:text-orange-600 transition">ABOUT US</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="text-black text-sm font-bold uppercase hover:text-orange-600 transition">CONTACT US</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" class="text-black text-sm font-bold uppercase hover:text-orange-600 transition">PRIVACY & POLICY</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/reviews' ) ); ?>" class="text-black text-sm font-bold uppercase hover:text-orange-600 transition">REVIEWS</a></li>
                    </ul>
                </nav>

                <!-- Promotional Pill Buttons -->
                <div class="hidden md:flex gap-3 mr-[100px]">
                    <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-full text-sm font-bold uppercase flex items-center gap-2 transition transform hover:scale-105">
                        🎁 BUY 2 GET 1 FREE
                    </a>
                    <a href="#" class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-full text-sm font-bold uppercase flex items-center gap-2 transition transform hover:scale-105">
                        🚚 FREE DELIVERY ALL OVER PAKISTAN
                    </a>
                </div>

                <!-- Header Icons (Search & Cart) -->
                <div class="flex gap-4 items-center ml-2">
                    <svg class="w-6 h-6 stroke-black hover:stroke-orange-600 cursor-pointer transition" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    
                    <!-- Cart Icon with Badge -->
                    <div class="relative">
                        <svg id="shopker-cart-icon" class="w-6 h-6 stroke-black hover:stroke-orange-600 cursor-pointer transition" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <!-- Cart Badge Counter -->
                        <span id="shopker-cart-count" class="absolute -top-2 -right-2 bg-orange-600 text-white text-xs font-black rounded-full w-5 h-5 flex items-center justify-center" style="display: none;">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>