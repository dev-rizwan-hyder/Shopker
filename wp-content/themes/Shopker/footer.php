<footer class="bg-[#FF6F00] text-white py-12 px-6 font-sans">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
        
        <div>
            <h3 class="text-xs font-black uppercase tracking-widest mb-8 opacity-90">Shopker</h3>
            <ul class="space-y-4">
                <li><a href="#" class="text-sm font-bold hover:underline">Refund Policy</a></li>
                <li><a href="#" class="text-sm font-bold hover:underline">Privacy Policy</a></li>
                <li><a href="#" class="text-sm font-bold hover:underline">Terms of Service</a></li>
                <li><a href="#" class="text-sm font-bold hover:underline">Profile</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-xs font-black uppercase tracking-widest mb-8 opacity-90">📩 GET IN TOUCH</h3>
            <div class="space-y-6">
                <p class="text-sm font-bold flex items-center gap-2">
                    📞 Contact Us via Call or WhatsApp
                </p>
                <p class="text-sm font-bold leading-relaxed">
                    📧 Or email us your queries during working hours (9 A.M – 6 P.M)
                </p>
                <p class="text-sm font-black mt-4">
                    Contact: +92 303 2180101
                </p>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-black uppercase tracking-widest mb-8 opacity-90">NEWSLETTER</h3>
            <p class="text-sm font-bold mb-6 leading-relaxed">
                ✨ Join us to get special offers, free giveaways, and once-in-a-lifetime deals! 🎁
            </p>
            
            <div class="flex items-center border border-white/30 rounded-sm overflow-hidden bg-white/10 focus-within:ring-1 focus-within:ring-white">
                <input 
                    type="email" 
                    placeholder="your-email@example.com" 
                    class="bg-transparent border-none text-white placeholder-white/70 text-sm py-3 px-4 w-full focus:ring-0 outline-none"
                >
                <button class="bg-[#FF7A1A] px-6 py-3 text-xs font-black uppercase border-l border-white/20 hover:bg-[#e66400] transition-colors">
                    Join
                </button>
            </div>
        </div>
    </div>

    <div class="mt-16 pt-8 border-t border-white/10 flex flex-col items-center gap-6">
        <div class="text-[10px] font-bold uppercase tracking-widest flex gap-4 opacity-80">
            <span>© SHOPKER 2026</span>
            <span>POWERED BY SHOPKER</span>
        </div>
        
        <div class="flex gap-5">
            <a href="#" class="hover:opacity-70 transition-opacity">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
            </a>
            <a href="#" class="hover:opacity-70 transition-opacity">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
        </div>
    </div>
</footer>

<!-- Global Cart Sidebar (Available on all pages) -->
<div id="shopker-cart-sidebar-overlay"></div>
<div id="shopker-cart-sidebar">
    <div class="shopker-sidebar-header">
        <h2>🛒 Your Cart</h2>
        <button class="shopker-sidebar-close" id="shopker-sidebar-close">✕</button>
    </div>
    <div class="shopker-sidebar-content">
        <div id="shopker-sidebar-items"></div>
        <div id="shopker-sidebar-summary"></div>
    </div>
</div>

<!-- Cart Sidebar Styles & Scripts -->
<style>
    /* Cart Sidebar Styles */
    #shopker-cart-sidebar {
        position: fixed;
        top: 0;
        right: -450px;
        width: 450px;
        height: 100vh;
        background: white;
        box-shadow: -5px 0 30px rgba(0,0,0,0.15);
        z-index: 9999;
        transition: right 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow-y: auto;
        padding-top: 0;
    }

    #shopker-cart-sidebar.open {
        right: 0;
    }

    #shopker-cart-sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    #shopker-cart-sidebar-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    .shopker-sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        position: sticky;
        top: 0;
        background: white;
        z-index: 100;
    }

    .shopker-sidebar-header h2 {
        font-size: 24px;
        font-weight: 900;
        color: #1a1a1a;
        margin: 0;
    }

    .shopker-sidebar-close {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: #999;
        transition: color 0.3s;
    }

    .shopker-sidebar-close:hover {
        color: #FF4500;
    }

    .shopker-sidebar-content {
        padding: 20px;
    }

    .shopker-sidebar-item {
        display: flex;
        gap: 12px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 12px;
        margin-bottom: 12px;
        border: 1px solid #f0f0f0;
    }

    .shopker-sidebar-item-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .shopker-sidebar-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .shopker-sidebar-item-details {
        flex: 1;
    }

    .shopker-sidebar-item-name {
        font-weight: 900;
        color: #1a1a1a;
        margin: 0 0 8px 0;
        font-size: 14px;
    }

    .shopker-sidebar-item-qty {
        font-size: 12px;
        color: #666;
        margin: 0 0 8px 0;
    }

    .shopker-sidebar-item-price {
        font-weight: 900;
        color: #FF4500;
        font-size: 16px;
    }

    .shopker-sidebar-empty {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .shopker-sidebar-empty-icon {
        font-size: 60px;
        margin-bottom: 16px;
    }

    .shopker-sidebar-summary {
        margin-top: 20px;
        padding: 20px;
        border-top: 2px solid #f0f0f0;
        background: #f9f9f9;
        border-radius: 12px;
    }

    .shopker-sidebar-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-weight: bold;
        color: #666;
    }

    .shopker-sidebar-summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        font-weight: 900;
        color: #1a1a1a;
        padding-top: 10px;
        border-top: 1px solid #ddd;
        margin-top: 10px;
    }

    .shopker-sidebar-summary-total .price {
        color: #FF4500;
    }

    .shopker-sidebar-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .shopker-sidebar-btn {
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-weight: 900;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
    }

    .shopker-sidebar-btn-view {
        background: #FF4500;
        color: white;
    }

    .shopker-sidebar-btn-view:hover {
        background: #e63e00;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,69,0,0.3);
    }

    .shopker-sidebar-btn-checkout {
        background: #1a1a1a;
        color: white;
    }

    .shopker-sidebar-btn-checkout:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        #shopker-cart-sidebar {
            width: 100%;
            right: -100%;
        }
    }
</style>

<script>
// Global Cart Sidebar Functions
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('shopker-cart-sidebar');
    const overlay = document.getElementById('shopker-cart-sidebar-overlay');
    const closeBtn = document.getElementById('shopker-sidebar-close');

    // Close sidebar functions
    window.openCartSidebar = function() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        updateCartSidebar();
    };

    window.closeCartSidebar = function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = 'auto';
    };

    // Close button and overlay click
    closeBtn.addEventListener('click', closeCartSidebar);
    overlay.addEventListener('click', closeCartSidebar);

    // Escape key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCartSidebar();
        }
    });

    // Update cart sidebar with current cart items
    window.updateCartSidebar = function() {
        const itemsContainer = document.getElementById('shopker-sidebar-items');
        const summaryContainer = document.getElementById('shopker-sidebar-summary');
        
        // Fetch cart data via AJAX
        fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>?action=wc_get_cart_contents', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.cart_contents) {
                let html = '';
                let total = 0;

                // Display items
                if (data.cart_contents.length > 0) {
                    data.cart_contents.forEach(item => {
                        const itemTotal = item.line_total;
                        total += itemTotal;
                        html += `
                            <div class="shopker-sidebar-item">
                                <div class="shopker-sidebar-item-image">
                                    <img src="${item.product_image}" alt="${item.product_name}">
                                </div>
                                <div class="shopker-sidebar-item-details">
                                    <p class="shopker-sidebar-item-name">${item.product_name}</p>
                                    <p class="shopker-sidebar-item-qty">Qty: ${item.quantity}</p>
                                    <p class="shopker-sidebar-item-price">Rs. ${parseInt(itemTotal).toLocaleString('en-PK')}</p>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<div class="shopker-sidebar-empty"><div class="shopker-sidebar-empty-icon">🛒</div><p>Your cart is empty</p></div>';
                }

                itemsContainer.innerHTML = html;

                // Display summary
                summaryContainer.innerHTML = `
                    <div class="shopker-sidebar-summary">
                        <div class="shopker-sidebar-summary-row">
                            <span>Subtotal:</span>
                            <span>Rs. ${parseInt(total).toLocaleString('en-PK')}</span>
                        </div>
                        <div class="shopker-sidebar-summary-row">
                            <span>Shipping:</span>
                            <span style="color: #22c55e;">FREE ✓</span>
                        </div>
                        <div class="shopker-sidebar-summary-total">
                            <span>TOTAL:</span>
                            <span class="price">Rs. ${parseInt(total).toLocaleString('en-PK')}</span>
                        </div>
                        <div class="shopker-sidebar-buttons">
                            <button class="shopker-sidebar-btn shopker-sidebar-btn-view" onclick="window.location.href='<?php echo esc_url(home_url('/cart')); ?>'">
                                📦 VIEW CART
                            </button>
                            <button class="shopker-sidebar-btn shopker-sidebar-btn-checkout" onclick="window.location.href='<?php echo esc_url(home_url('/checkout')); ?>'">
                                🔒 CHECKOUT
                            </button>
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => {
            console.log('Error fetching cart:', err);
        });
    };
});
</script>

<?php wp_footer(); ?>
</body>
</html>
</script>