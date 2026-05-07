<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
session_start();

include 'includes/db.php';

$errors = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = $conn->real_escape_string(trim($_POST["identifier"]));
    $password = $_POST["password"];
    $identifierField = '';

    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $identifierField = "email";
    } elseif (preg_match('/^01[3-9]\d{8}$/', $identifier)) {
        $identifierField = "cnumber";
    } else {
        $identifierField = "id";
    }

    $query = "SELECT id, password, status FROM credential WHERE $identifierField = '$identifier'";
    $result = $conn->query($query);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row["password"]) {
            if ($row["status"] == 1) {
                $_SESSION["id"] = $row["id"];
                header("Location: UserProfile");
                exit;
            } else {
                $errors[] = "Account is not active.";
            }
        } else {
            $errors[] = "Invalid credentials.";
        }
    } else {
        $errors[] = "Account not found.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #1e293b;
        }

        .login-card {
            background: #ffffff;
            padding: 48px;
            border-radius: 24px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }

        h2 {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #0f172a;
        }

        p.subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 32px;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #475569;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
        }

        .error-msg {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            border: 1px solid #fecaca;
        }

        .footer-links {
            margin-top: 24px;
            text-align: center;
            font-size: 0.9rem;
            color: #64748b;
        }

        .footer-links a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Please enter your details to sign in.</p>

        <?php if (!empty($errors)) : ?>
            <div class="error-msg">
                <?php foreach ($errors as $error) : ?>
                    <p style="margin:0;"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Identifier</label>
                <input type="text" name="identifier" placeholder="ID, Email or Phone" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="footer-links">
            <p><a href="Recover">Forgot password?</a></p>
            <p>New here? <a href="Signup">Create an account</a></p>
            <p><a href="Index">Back to Homepage</a></p>
        </div>
    </div>
</body>
</html>