<?php
include("UserSidebar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ADDRESS BOOK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }
        #sidebar {
            float: left;
            width: 15%; /* Adjust width as needed */
        }
        #content {
            float: left;
            width: 45%; /* Adjust width as needed */
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin: 0;
        }
        ul li a {
            display: block;
            padding: 10px;
            background-color: #eee;
            text-decoration: none;
        }
        ul li a:hover {
            background-color: #ddd;
        }
        #logout-container {
            position: absolute;
            top: 20px;
            right: 10px;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #ff0000;
        }

        /* Add CSS for the Update Address Form */
        .update-address-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .address-input {
            width: 75%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .update-button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .update-button:hover {
            background-color: #005bb7;
        }
    </style>
</head>
<body>
<?php
    if (isset($_POST['logout'])) {
        // Destroy the session and redirect to the Login page
        session_destroy();
        header("Location: UserLogin.php");
        exit();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM credential WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $email = $row['email'];
        // Fetch the user's current address from the database
        $address_query = "SELECT address FROM credential WHERE id = '$id'";
        $address_result = mysqli_query($conn, $address_query);
        if ($address_row = mysqli_fetch_assoc($address_result)) {
            $current_address = $address_row['address'];
            // Split the address components
            $address_components = explode(', ', $current_address);
            $house_road = isset($address_components[0]) ? $address_components[0] : '';
            $address_line1 = isset($address_components[1]) ? $address_components[1] : '';
            $address_line2 = isset($address_components[2]) ? $address_components[2] : '';
            $state = isset($address_components[3]) ? $address_components[3] : '';
            $zip = isset($address_components[4]) ? $address_components[4] : '';
        }
    }
    ?>

    <div id="content">
        <h2>Current Address</h2>
        <p><?php echo $current_address; ?></p>

        <h2>Update Your Address</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="update-address-form">
            <label for="house_road">House/Road:</label><br>
            <input type="text" name="house_road" value="<?php echo $house_road; ?>" class="address-input">
            <br>
            <label for="address_line1">Address Line 1:</label><br>
            <input type="text" name="address_line1" value="<?php echo $address_line1; ?>" class="address-input">
            <br>
            <label for="address_line2">Address Line 2:</label><br>
            <input type="text" name="address_line2" value="<?php echo $address_line2; ?>" class="address-input">
            <br>
            <label for="state">State:</label><br>
            <input type="text" name="state" value="<?php echo $state; ?>" class="address-input">
            <br>
            <label for="zip">Zip Code:</label><br>
            <input type="text" name="zip" value="<?php echo $zip; ?>" class="address-input">
            <br>
            <input type="submit" name="update_address" value="Update Address" class="update-button">
        </form>

        <?php
        // update
        if (isset($_POST["update_address"])) {
            $house_road = mysqli_real_escape_string($conn, $_POST['house_road']);
            $address_line1 = mysqli_real_escape_string($conn, $_POST['address_line1']);
            $address_line2 = mysqli_real_escape_string($conn, $_POST['address_line2']);
            $state = mysqli_real_escape_string($conn, $_POST['state']);
            $zip = mysqli_real_escape_string($conn, $_POST['zip']);

            // Concatenate the address components with a comma
            $new_address = "$house_road, $address_line1, $address_line2, $state, $zip";

            $update_address_query = "UPDATE credential SET address = '$new_address' WHERE id = '$id'";
            if (mysqli_query($conn, $update_address_query)) {
                echo "Address updated successfully!";
                // Refresh page
                echo '<script>window.location.href = "UserAddress.php";</script>';
    exit();
            } else {
                echo "Error updating address: " . mysqli_error($conn);
            }
        }
        ?>

        <div id="logout-container">
            <form method="post">
                <input type="submit" name="logout" class="logout-button" value="Log Out">
            </form>
        </div>
    </div>

    <?php
    mysqli_close($conn);
    ?>
</body>
</html>
