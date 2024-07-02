<?php
session_start(); // Start PHP session

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost"; // Replace with your host
$username = "root";        // Replace with your MySQL username
$password = "";            // Replace with your MySQL password
$dbname = "host";          // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store form data
$btitle = $bintro = $bdesc = "";
$btitle_err = $bintro_err = $bdesc_err = "";
$bimag_err = "";

// Function to upload image and return the filename
function uploadImage($file) {
    $targetDir = "C:/xampp/htdocs/host/assets/";
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file is an actual image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "";
    }

    // Check file size
    if ($file["size"] > 500000) { // 500KB limit
        return "";
    }

    // Allow only certain file formats
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($fileType, $allowedTypes)) {
        return "";
    }

    // Upload file to server
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $fileName; // Return the filename
    } else {
        return "";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $btitle = trim($_POST["btitle"]);
    $bintro = trim($_POST["bintro"]);
    $bdesc = trim($_POST["bdesc"]);

    // Check if fields are empty
    if (empty($btitle)) {
        $btitle_err = "Please enter a title.";
    }
    if (empty($bintro)) {
        $bintro_err = "Please enter an introduction.";
    }
    if (empty($bdesc)) {
        $bdesc_err = "Please enter a description.";
    }

    // Validate and upload image
    if (!empty($_FILES["bimag"]["name"])) {
        $uploadedFile = uploadImage($_FILES["bimag"]);
        if ($uploadedFile) {
            $bimag = $uploadedFile; // Store the filename in $bimag
        } else {
            $bimag_err = "Failed to upload image.";
        }
    } else {
        $bimag_err = "Please select an image.";
    }

    // If no errors, insert into database
    if (empty($btitle_err) && empty($bintro_err) && empty($bdesc_err) && empty($bimag_err)) {
        // Prepare SQL statement
        $sql = "INSERT INTO blogs (uid, btitle, bintro, bdesc, bimag) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $_SESSION['uid'], $btitle, $bintro, $bdesc, $bimag);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to success page or do something else (e.g., display success message)
            header("Location: blogSuccess.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: row;
            margin: 20px;
        }
        .side-menu {
            width: 200px;
            background-color: #f0f0f0;
            padding: 10px;
        }
        .side-menu a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #333;
            padding: 8px;
            border-radius: 4px;
        }
        .side-menu a:hover {
            background-color: #ddd;
        }
        .main-content {
            flex: 1;
            margin-left: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input[type="text"], .form-group textarea, .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group textarea {
            height: 150px;
            resize: vertical; /* Allow vertical resizing of textarea */
        }
        .form-group .char-count {
            font-size: 12px;
            color: #666;
        }
        .form-group .error {
            color: red;
            font-size: 12px;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'dashboard.php'; ?> <!-- Importing sidebar menu -->

    <div class="main-content">
        <h2>Blog Upload</h2>
        <p>Welcome, <?php echo $_SESSION['uid']; ?>!</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="btitle">Blog Title:</label>
                <input type="text" id="btitle" name="btitle" value="<?php echo htmlspecialchars($btitle); ?>" maxlength="100" required>
                <span class="char-count"><span id="btitle-count">0</span>/100 characters</span>
                <span class="error"><?php echo $btitle_err; ?></span>
            </div>
            <div class="form-group">
                <label for="bintro">Introduction:</label>
                <textarea id="bintro" name="bintro" maxlength="500" required><?php echo htmlspecialchars($bintro); ?></textarea>
                <span class="char-count"><span id="bintro-count">0</span>/500 characters</span>
                <span class="error"><?php echo $bintro_err; ?></span>
            </div>
            <div class="form-group">
                <label for="bdesc">Description:</label>
                <textarea id="bdesc" name="bdesc" maxlength="2000" required><?php echo htmlspecialchars($bdesc); ?></textarea>
                <span class="char-count"><span id="bdesc-count">0</span>/2000 characters</span>
                <span class="error"><?php echo $bdesc_err; ?></span>
            </div>
            <div class="form-group">
                <label for="bimag">Blog Image:</label>
                <input type="file" id="bimag" name="bimag" accept="image/*" required>
                <span class="error"><?php echo $bimag_err; ?></span>
            </div>
            <div class="form-group">
                <button type="submit">Upload Blog</button>
            </div>
        </form>
    </div>

    <script>
        // Character counters
        const btitleInput = document.getElementById('btitle');
        const bintroInput = document.getElementById('bintro');
        const bdescInput = document.getElementById('bdesc');

        const btitleCount = document.getElementById('btitle-count');
        const bintroCount = document.getElementById('bintro-count');
        const bdescCount = document.getElementById('bdesc-count');

        btitleInput.addEventListener('input', function() {
            btitleCount.textContent = btitleInput.value.length;
        });

        bintroInput.addEventListener('input', function() {
            bintroCount.textContent = bintroInput.value.length;
        });

        bdescInput.addEventListener('input', function() {
            bdescCount.textContent = bdescInput.value.length;
        });
    </script>
</body>
</html>