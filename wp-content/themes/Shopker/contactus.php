<?php
/**
 * Template Name: ShopKer Contact Layout
 */

get_header(); ?>

<style>
    :root {
        --sk-orange: #FF3D00; /* Your brand orange */
        --sk-dark: #1a1a1a;
        --sk-bg: #ffffff;
    }

    .sk-contact-section {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 15px;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .sk-title-area {
        text-align: center;
        margin-bottom: 50px;
    }

    .sk-title-area h1 {
        font-size: 42px;
        font-weight: 900;
        letter-spacing: -1px;
        color: var(--sk-dark);
        margin-bottom: 10px;
    }

    .sk-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 30px;
        align-items: start;
    }

    /* Form Container */
    .sk-form-box {
        background: #fff;
        padding: 40px;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    /* Fixing Shortcode Rendering: Ensure plugin CSS is supported */
    .sk-form-box input[type="text"],
    .sk-form-box input[type="email"],
    .sk-form-box textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .sk-form-box input[type="submit"] {
        background: var(--sk-orange);
        color: #fff;
        border: none;
        padding: 15px 30px;
        font-weight: bold;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.3s;
    }

    /* Right Info Sidebar */
    .sk-info-item {
        background: #FFF9F6;
        border: 1px solid #FFEDDE;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .sk-number {
        background: var(--sk-orange);
        color: #fff;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        flex-shrink: 0;
    }

    .sk-text h4 { margin: 0; font-size: 16px; color: #333; }
    .sk-text p { margin: 0; color: #666; font-size: 14px; }

    @media (max-width: 850px) {
        .sk-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="sk-contact-section">
    <div class="sk-title-area">
        <h1>CONTACT US</h1>
        <p>Your order status and queries are our priority.</p>
    </div>

    <div class="sk-grid">
        <div class="sk-form-box">
            <?php 
            /** 
             * FIX: If the shortcode appeared as text, ensure the ID matches 
             * your Contact Form 7 dashboard. Replace 'your-form-id' below.
             */
            echo do_shortcode('[contact-form-7 id="d6a28c3" title="Contact form 1"]'); 
            ?>
        </div>

        <div class="sk-sidebar">
            <div class="sk-info-item">
                <div class="sk-number">1</div>
                <div class="sk-text">
                    <h4>WhatsApp Support</h4>
                    <p>+92 303 2180101</p>
                </div>
            </div>

            <div class="sk-info-item">
                <div class="sk-number">2</div>
                <div class="sk-text">
                    <h4>Working Hours</h4>
                    <p>Mon - Sat: 9:00 AM – 6:00 PM</p>
                </div>
            </div>

            <div class="sk-info-item" style="background: #F4F4F4; border-color: #E0E0E0;">
                <div class="sk-number" style="background: #333;">3</div>
                <div class="sk-text">
                    <h4>Email Us</h4>
                    <p>support@shopker.com</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>