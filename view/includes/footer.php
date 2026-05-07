<?php
if (!defined('APP_RUNNING')) {
    header("Location: Index");
    exit();
}
?>
<style>
    /* Global Sticky Footer Fix */
    html, body {
        height: 100%;
        margin: 0;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    /* This targets the main content area in most of our pages */
    .main-content, .container, .gallery-container, .dashboard-layout, .page-wrapper, .gallery-details, .content {
        flex: 1 0 auto;
    }

    .footer {
        flex-shrink: 0;
        background-color: #0f172a; /* Darker professional color to match new theme */
        color: #94a3b8;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        padding: 40px 20px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .footer a {
        color: #cbd5e1;
        text-decoration: none;
        margin: 5px 15px;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .footer a:hover {
        color: #3b82f6;
    }

    .footer .footer-links {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 20px;
    }

    .footer .line {
        border-top: 1px solid rgba(255,255,255,0.1);
        width: 100%;
        max-width: 1200px;
        margin: 20px 0;
    }

    .copyright {
        text-align: center;
        font-size: 0.85rem;
        line-height: 1.6;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .social-icons img {
        opacity: 0.7;
        transition: 0.3s;
        filter: grayscale(1) invert(1);
    }

    .social-icons a:hover img {
        opacity: 1;
        filter: grayscale(0) invert(0);
        transform: translateY(-3px);
    }
</style>

<div class="footer">
    <div class="footer-links">
        <a href="Privacy">Privacy Policy</a>
        <a href="collection-statement">Collection Statement</a>
        <a href="Term">Terms & Conditions</a>
        <a href="Ad">Advertise</a>
        <a href="HomeContactUs">Contact Us</a>
    </div>
    
    <div class="social-icons">
        <a href="https://www.instagram.com/" target="_blank"><img src="visuals/logo/instagram.png" alt="Instagram" width="24"></a>
        <a href="https://twitter.com/" target="_blank"><img src="visuals/logo/twitter.png" alt="Twitter" width="24"></a>
        <a href="https://www.facebook.com/" target="_blank"><img src="visuals/logo/facebook.png" alt="Facebook" width="24"></a>
        <a href="https://www.youtube.com/" target="_blank"><img src="visuals/logo/youtube.png" alt="YouTube" width="24"></a>
    </div>

    <div class="line"></div>
    
    <div class="copyright">
        &copy; <?php echo date('Y'); ?> EventX Bangladesh. All rights reserved.<br>
        <span style="font-size: 0.75rem; opacity: 0.6;">A production of JAZZ Digital Media division of ZiT.</span>
    </div>
</div>
