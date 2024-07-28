<?php

$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";
$con = new mysqli($servername, $username, $pass, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if(isset($_GET['email']) && isset($_GET['verifi_code']))
{
    
    $query1="SELECT * FROM `credential` WHERE `email`='$_GET[email]'  AND `verification_code` ='$_GET[verifi_code]' ";
    $result=mysqli_query($con,$query1);

    if($result)
    {
       
        if($result->num_rows==1) 
        {  
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['is_verified'] ==0)
            {
                $update="UPDATE `credential` SET `is_verified`='1' WHERE `email`='$result_fetch[email]'";
                if(mysqli_query($con,$update))
                {
                    echo "
                        <script>
                            alert('Email Verification Successfully');
                            window.location.href='Registration.php';
                        </script> 
                    ";
                }
                else
                {
                    echo "
                        <script>
                            alert('Cannot Run Query');
                            window.location.href='index.php';
                        </script> 
                    ";
                }
            }
            else
            {
                echo "
                    <script>
                        alert('Verification is done. Please Login');
                        window.location.href='Login.php';
                    </script> 
                 ";
            }
        }
        else
        {
            echo "
            <script>
                alert('Number of rows is not 1');
                window.location.href='index.php';
            </script> 
             ";
        }
        
    }
    else
    {
        echo "
            <script>
                alert('Cannot Run Query');
                window.location.href='Registration.php';
            </script> 
        ";
    }
}

?>
