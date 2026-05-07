<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$successMessage = "";
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $cpassword = $conn->real_escape_string($_POST['cpassword']);
    $cnumber = $conn->real_escape_string($_POST['cnumber']);
    $verifi_code = bin2hex(random_bytes(16));

    if ($password !== $cpassword) { $errorMessages[] = "Passwords do not match."; }

    if (empty($errorMessages)) {
        $sql = "INSERT INTO credential (name, email, cnumber, password, verifi_code) VALUES ('$name', '$email', '$cnumber', '$password', '$verifi_code')";
        if ($conn->query($sql) === true) {
            if (file_exists('../vendor/autoload.php')) require '../vendor/autoload.php';
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'eventa2zmanagement@gmail.com';
                $mail->Password = 'kawn bptd orqf nmci';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->setFrom('eventa2zmanagement@gmail.com', 'EventX');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email - EventX';
                $mail->Body = "Confirm your account: <a href='http://".$_SERVER['HTTP_HOST']."/Event-Management/verify?email=$email&verifi_code=$verifi_code'>Verify Now</a>";
                $mail->send();
                $successMessage = "Signup successful! Check your email for verification.";
            } catch (Exception $e) { $errorMessages[] = "Error sending email."; }
        } else { $errorMessages[] = "Database error."; }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f1f5f9; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 40px 0; }
        .card { background: #fff; padding: 40px; border-radius: 24px; width: 100%; max-width: 450px; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-top: 0; color: #0f172a; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 5px; color: #475569; }
        input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 10px; box-sizing: border-box; }
        .btn { width: 100%; padding: 14px; background: #2563eb; color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; margin-top: 10px; }
        .btn:hover { background: #1d4ed8; }
        .status { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .text-center { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #64748b; }
        a { color: #2563eb; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Create Account</h2>
        <?php if ($successMessage): ?> <div class="status success"><?php echo $successMessage; ?></div> <?php endif; ?>
        <?php if (!empty($errorMessages)): ?> <div class="status error"><?php echo implode("<br>", $errorMessages); ?></div> <?php endif; ?>
        <form method="POST">
            <div class="form-group"><label>Full Name</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Contact Number</label><input type="text" name="cnumber" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Confirm Password</label><input type="password" name="cpassword" required></div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <div class="text-center">Already have an account? <a href="UserLogin">Sign In</a></div>
    </div>
</body>
</html>