<?php
$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";
$con = new mysqli($servername, $username, $pass, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if(isset($_GET['email']) && isset($_GET['reset_token']))
{
    date_default_timezone_set('Asia/Dhaka');
    $date = date("Y-m-d");
    $query = "SELECT * FROM `credential` WHERE `email`=? AND `resettoken`=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $_GET['email'], $_GET['reset_token']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($result)
    {
        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_assoc($result);
            
            if ($row['resettoken'] !== null) {
                echo "
                    <div id='divarea'>
                        <form method='POST'>
                            <h1>Create New Password</h1>
                            <input id='pass' type='password' name='password' placeholder='New Password' required>
                            <input id='con_pass' type='password' name='con_password' placeholder='Confirm Password' required>
                            <button id='update_btn' name='update_btn'> Update </button>
                        </form>
                    </div>
                ";
            } else {
                echo "
                    <script>
                        alert('Password has already been updated.');
                        window.location.href='UserLogin.php';
                    </script>
                ";
            }
        }
        else
        {
            echo "
                <script>
                    alert('Invalid or Expired Link');
                    window.location.href='Recover.php';
                </script>
            ";
        }
    }
    else
    {
        echo "
            <script>
                alert('Server Down! try again later');
                window.location.href='Home.php';
            </script>
        ";
    }
}

?>

<?php

if(isset($_POST['update_btn']))
{
    $password = $_POST['password'];
    $confirm_password = $_POST['con_password'];

    if ($password == $confirm_password) {
        $update_pass = password_hash($password, PASSWORD_BCRYPT);
        $update_query = "UPDATE `credential` SET `password`=?, `resettoken`=NULL WHERE `email`=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "ss", $update_pass, $_GET['email']);

        if(mysqli_stmt_execute($stmt))
        {
            echo "
                <script>
                    alert('Password Updated Successfully');
                    window.location.href='UserLogin.php';
                </script>
            ";
            exit; // Add this line to prevent further execution
        }
        else
        {
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
                alert('Password and Confirm Password do not match');
                window.location.href='Update_password.php';
            </script>
        ";
    }
}

?>

<style>
* {
  margin: 0;
  padding: 0;
  list-style: none;
  box-sizing: border-box;
}

body {
  height: 100%;
  width: 100%;
  background-color: #f0f2f5;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
  position: static;
}

h1 {
    margin-bottom: 50px;
}

#divarea {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    background: #fff;
    box-shadow: 0 0 10px #ddd;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
}

#pass, #con_pass {
    text-align: center;
    width: 100%;
    display: block;
    border: 1px solid #ddd;
    padding: 14px 16px;
    font-size: 19px;
    border-radius: 6px;
    margin-bottom: 15px;
}

#update_btn {
    text-align: center;
    width: 85%;
    display: block;
    border: 1px solid #ddd;
    padding: 14px 16px;
    font-size: 19px;
    border-radius: 6px;
    margin-bottom: 15px;
    margin-inline: 7.5%;
    background-color: coral;
    font-weight: bolder;
}

#update_btn:hover {
    background-color: rgb(154, 49, 11);
}
</style>