<?php if(!defined('APP_RUNNING')) define('APP_RUNNING', true); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventX - Premier Event Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background: #020617;
            color: #fff;
            overflow-x: hidden;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(to bottom, rgba(2, 6, 23, 0.5), #020617), url('visuals/images/bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(to right, #60a5fa, #c084fc, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInDown 1s ease-out;
        }

        .hero p {
            font-size: clamp(1rem, 3vw, 1.5rem);
            color: #94a3b8;
            max-width: 700px;
            margin-bottom: 40px;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        .cta-group {
            display: flex;
            gap: 20px;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.1rem;
        }

        .btn-primary {
            background: #3b82f6;
            color: #fff;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5);
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-3px);
            box-shadow: 0 20px 30px -10px rgba(59, 130, 246, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: #fff;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Feature section preview */
        .features {
            padding: 100px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255,255,255,0.02);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        .feature-card:hover {
            background: rgba(255,255,255,0.05);
            transform: translateY(-5px);
        }

        .feature-card h3 {
            color: #60a5fa;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include 'includes/HomeTopBar.php'; ?>

    <main class="hero">
        <h1>Unforgettable Events Start Here</h1>
        <p>Your premier event management partner. We design, plan and execute world-class experiences tailored to your vision.</p>
        <div class="cta-group">
            <a href="UserTicket" class="btn btn-primary">Book Now</a>
            <a href="HomeServices" class="btn btn-secondary">Our Services</a>
        </div>
    </main>

    <section class="features">
        <div class="feature-card">
            <h3>Venue Selection</h3>
            <p>From historic ballrooms to modern industrial spaces, we find the perfect backdrop for your story.</p>
        </div>
        <div class="feature-card">
            <h3>Expert Planning</h3>
            <p>Our dedicated team handles every detail, ensuring a seamless and stress-free planning process.</p>
        </div>
        <div class="feature-card">
            <h3>Creative Design</h3>
            <p>We transform concepts into breathtaking realities with bespoke decor and innovative concepts.</p>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
