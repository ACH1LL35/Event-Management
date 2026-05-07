<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
include 'includes/db.php';

if (file_exists('../vendor/autoload.php')) {
    require '../vendor/autoload.php';
} else {
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../vendor/phpmailer/phpmailer/src/Exception.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$statusMessage = "";
$statusType = "";

function sendMail($_email, $reset_token) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eventa2zmanagement@gmail.com';
        $mail->Password   = 'kawn bptd orqf nmci';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('eventa2zmanagement@gmail.com', 'EventX Support');
        $mail->addAddress($_email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request - EventX';
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/Event-Management/Update_password?email=$_email&reset_token=$reset_token";
        
        $mail->Body = "<h3>Password Reset</h3><p>Click the link below to reset your password:</p><a href='$resetLink'>$resetLink</a>";
        $mail->send();
        return true;
    } catch (Exception $e) { return false; }
}

if (isset($_POST['sendlink_btn'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $query = "SELECT * FROM `credential` WHERE `email`='$email'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows == 1) {
        $reset_token = bin2hex(random_bytes(16));
        $expire_date = date('Y-m-d', strtotime('+1 day'));
        $query1 = "UPDATE `credential` SET `resettoken`='$reset_token',`resettokenexpire`='$expire_date' WHERE `email`='$email'";
        if ($conn->query($query1) && sendMail($email, $reset_token)) {
            $statusMessage = "Recovery link sent to your email.";
            $statusType = "success";
        } else {
            $statusMessage = "Mail server error. Try again later.";
            $statusType = "error";
        }
    } else {
        $statusMessage = "Email address not found.";
        $statusType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Password - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f1f5f9; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; color: #1e293b; }
        .card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border: 1px solid #e2e8f0; text-align: center; }
        h2 { margin-top: 0; color: #0f172a; }
        p { color: #64748b; font-size: 0.9rem; margin-bottom: 25px; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #cbd5e1; border-radius: 10px; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .btn:hover { background: #1d4ed8; }
        .status { padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        a { color: #2563eb; text-decoration: none; font-size: 0.9rem; display: block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Recover Access</h2>
        <p>Enter your email to receive a password reset link.</p>
        <?php if ($statusMessage): ?>
            <div class="status <?php echo $statusType; ?>"><?php echo $statusMessage; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit" name="sendlink_btn" class="btn">Send Recovery Link</button>
        </form>
        <a href="UserLogin">Back to Login</a>
    </div>
</body>
</html>