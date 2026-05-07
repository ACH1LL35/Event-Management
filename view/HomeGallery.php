<?php if(!defined('APP_RUNNING')) define('APP_RUNNING', true); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a;
            margin: 0;
            padding: 0;
            color: #f8fafc;
        }

        .hero-section {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), #0f172a), url('visuals/images/gal.jpg');
            background-size: cover;
            background-position: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gallery-container {
            max-width: 1200px;
            margin: 0 auto 50px;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            border-color: rgba(96, 165, 250, 0.5);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9), transparent);
            display: flex;
            align-items: flex-end;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .overlay {
            opacity: 1;
        }

        .overlay span {
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/HomeTopBar.php'; ?>

    <div class="hero-section">
        <h1>Moments Captured</h1>
        <p>Explore our past events and vibrant gallery</p>
    </div>

    <div class="gallery-container">
        <?php
        include 'includes/db.php';
        $basePath = "visuals/gallery/";

        try {
            $stmt = $conn->prepare("SELECT id, title, image_path FROM gallery_data");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $imageURL = $basePath . $row['image_path'];
                $imageFS = __DIR__ . '/../' . $imageURL;

                if (file_exists($imageFS)) {
                    ?>
                    <div class="gallery-item">
                        <a href="details?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo $imageURL; ?>" alt="Gallery Image">
                            <div class="overlay">
                                <span><?php echo htmlspecialchars($row['title']); ?></span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
        } catch (Exception $e) {
            echo "<p style='color:red; text-align:center;'>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>