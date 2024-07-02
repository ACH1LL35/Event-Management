<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login_handler.php" method="post">
        <div>
            <label for="uemail">Email:</label>
            <input type="email" id="uemail" name="uemail" required>
        </div>
        <div>
            <label for="upass">Password:</label>
            <input type="password" id="upass" name="upass" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>