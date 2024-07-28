<?php

$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";
$con = new mysqli($servername, $username, $pass, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Update the path to the correct location
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($_email, $reset_token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                     //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                            //Enable SMTP authentication
        $mail->Username   = 'eventa2zmanagement@gmail.com';  //SMTP username
        $mail->Password   = 'kawn bptd orqf nmci';           //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     //Enable implicit TLS encryption
        $mail->Port       = 465;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('eventa2zmanagement@gmail.com', 'A2Z EVENTS');
        $mail->addAddress($_email);                          //Add a recipient

        //Content
        $mail->isHTML(true);                                 //Set email format to HTML
        $mail->Subject = 'Password Reset Link from A2Z Events';
        $mail->Body    = "We got a request from you to reset your password! <br>
          Click the link below : <br>
          <a href='http://localhost/Project/Update_password.php?email=$_email&reset_token=$reset_token'> Reset Password</a>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['sendlink_btn'])) {
    $query = "SELECT * FROM `credential` WHERE `email`='$_POST[email]'";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/Dhaka');
            $date = date("Y-m-d");
            
            // Set resettokenexpire to be 1 day plus the current date
            $expire_date = date('Y-m-d', strtotime($date . ' + 1 days'));
            
            $query1 = "UPDATE `credential` SET `resettoken`='$reset_token',`resettokenexpire`='$expire_date' WHERE `email`='$_POST[email]'";
            if (mysqli_query($con, $query1) && sendMail($_POST["email"], $reset_token)) {
                echo "
                    <script>
                        alert('Password Reset Link Sent to mail');
                        window.location.href='Recover.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Server Down! try again later');
                        window.location.href='Recover.php';
                    </script>
                ";
            }
        } else {
            echo "
                <script>
                    alert(' Email not Found ');
                    window.location.href='Recover.php';
                </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('Cannot Run Query');
                window.location.href='Recover.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="email"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn" name="sendlink_btn">Reset Password</button>
            </div>
        </form>
        <center>
            <p>If the provided email matches an account, a recovery email will be sent.</p>
            <p><a href="UserLogin.php">Back to Login</a></p>
        </center>
    </div>
</body>
</html>