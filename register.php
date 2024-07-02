<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register_handler.php" method="post">
        <div>
            <label for="fname">Full Name:</label>
            <input type="text" id="fname" name="fname" required>
        </div>
        <div>
            <label for="uemail">Email:</label>
            <input type="email" id="uemail" name="uemail" required>
        </div>
        <div>
            <label for="upass">Password:</label>
            <input type="password" id="upass" name="upass" required>
        </div>
        <button type="submit">Register</button>
    </form>
</body>
</html>