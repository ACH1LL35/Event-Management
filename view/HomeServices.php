<?php if(!defined('APP_RUNNING')) define('APP_RUNNING', true); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .hero-banner {
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('visuals/images/bg.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 80px 20px;
            text-align: center;
        }

        .hero-banner h1 {
            font-size: 3rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .hero-banner p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }

        .services-grid {
            max-width: 1200px;
            margin: -50px auto 60px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .service-image {
            height: 240px;
            overflow: hidden;
            position: relative;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-card:hover .service-image img {
            transform: scale(1.1);
        }

        .service-info {
            padding: 30px;
        }

        .service-info h2 {
            font-size: 1.5rem;
            margin: 0 0 12px;
            color: #0f172a;
        }

        .service-info p {
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .coming-soon {
            background: #f1f5f9;
            color: #64748b;
        }
    </style>
</head>
<body>
    <?php include 'includes/HomeTopBar.php'; ?>

    <div class="hero-banner">
        <h1>Excellence in Execution</h1>
        <p>From conceptualization to the final applause, we provide comprehensive event solutions tailored to your unique needs.</p>
    </div>

    <div class="services-grid main-content">
        <!-- Venue Card -->
        <div class="service-card">
            <div class="service-image"><img src="visuals/images/ven.jpg" alt="Venue Selection"></div>
            <div class="service-info">
                <span class="badge">Available Now</span>
                <h2>Venue Selection</h2>
                <p>We partner with the most exclusive locations to find the perfect backdrop for your corporate or private events.</p>
            </div>
        </div>

        <!-- Staffing Card -->
        <div class="service-card">
            <div class="service-image"><img src="visuals/images/staff.jpg" alt="Professional Staffing"></div>
            <div class="service-info">
                <span class="badge">Available Now</span>
                <h2>Professional Staffing</h2>
                <p>Our highly trained team ensures every guest is treated with world-class hospitality and attention to detail.</p>
            </div>
        </div>

        <!-- Decoration Card -->
        <div class="service-card">
            <div class="service-image"><img src="visuals/images/deco.jpg" alt="Creative Decoration"></div>
            <div class="service-info">
                <span class="badge coming-soon">Coming Soon</span>
                <h2>Creative Decoration</h2>
                <p>Bespoke floral arrangements, lighting designs, and thematic decor to transform any space into a masterpiece.</p>
            </div>
        </div>

        <!-- Supplies Card -->
        <div class="service-card">
            <div class="service-image"><img src="visuals/images/sup.jpg" alt="Event Supplies"></div>
            <div class="service-info">
                <span class="badge coming-soon">Coming Soon</span>
                <h2>Event Supplies & A/V</h2>
                <p>Top-tier audio-visual equipment and logistics support to power your conferences and presentations.</p>
            </div>
        </div>

        <!-- Catering Card -->
        <div class="service-card">
            <div class="service-image"><img src="visuals/images/cat.jpg" alt="Gourmet Catering"></div>
            <div class="service-info">
                <span class="badge coming-soon">Coming Soon</span>
                <h2>Gourmet Catering</h2>
                <p>Exquisite culinary experiences featuring local and international cuisines curated by master chefs.</p>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>