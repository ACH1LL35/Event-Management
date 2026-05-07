<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a; /* Deep dark blue-black */
            margin: 0;
            padding: 0;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .details-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            max-width: 1000px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 768px) {
            .details-card {
                grid-template-columns: 1fr;
            }
        }

        .image-section {
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .image-section img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: transform 0.5s ease;
        }

        .image-section img:hover {
            transform: scale(1.02);
        }

        .info-section {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-top: 0;
            background: linear-gradient(to right, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .info-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #cbd5e1;
            margin-bottom: 30px;
        }

        .meta-info {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }

        .btn-outline {
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.4);
        }

        .error-container {
            text-align: center;
            padding: 100px;
        }
    </style>
</head>
<body>
    <?php include 'includes/HomeTopBar.php'; ?>

    <main class="main-content">
        <?php
            include 'includes/db.php';
            $basePath = "visuals/gallery/";

            try {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $stmt = $conn->prepare("SELECT title, description, image_path, created_at FROM gallery_data WHERE id = ?");
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $details = $result->fetch_assoc();

                    if ($details) {
                        ?>
                        <div class="details-card">
                            <div class="image-section">
                                <img src="<?php echo $basePath . htmlspecialchars($details['image_path']); ?>" alt="Event Image">
                            </div>
                            <div class="info-section">
                                <h2><?php echo htmlspecialchars($details['title']); ?></h2>
                                <p><?php echo nl2br(htmlspecialchars($details['description'])); ?></p>
                                
                                <div class="meta-info">
                                    <span>📅 Posted on: <?php echo date('M j, Y', strtotime($details['created_at'])); ?></span>
                                </div>

                                <div class="action-buttons">
                                    <a href="UserTicket" class="btn btn-primary">Book This Event</a>
                                    <a href="HomeGallery" class="btn btn-outline">Back to Gallery</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<div class="error-container"><h2>Image Not Found</h2><p>We couldn\'t find the details you were looking for.</p><a href="HomeGallery" class="btn btn-outline">Return to Gallery</a></div>';
                    }
                } else {
                    echo '<div class="error-container"><h2>Invalid Request</h2><p>No ID was provided.</p><a href="HomeGallery" class="btn btn-outline">Return to Gallery</a></div>';
                }
            } catch (Exception $e) {
                echo '<div class="error-container"><h2>Error</h2><p>' . htmlspecialchars($e->getMessage()) . '</p></div>';
            }
        ?>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
