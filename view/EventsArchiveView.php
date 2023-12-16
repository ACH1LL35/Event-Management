<?php

// Include the controller file
include_once('../controller/EventsArchiveController.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Archive</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
        }

        .content {
            padding-left: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }
        /* Styles for the logout form */
        .logout-form {
            text-align: center;
        }

        .logout-form .logout-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 200px;
            text-decoration: none;
        }

        .logout-form .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Event Log List</h1>
        <form method="get">
        <table border="1">
            <tr>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Event Details</th>
                <th>Posted By [ID]</th>
                <th>Action</th>
            </tr>
        <?php
        if(isset($_GET['del']))
        {
            $id= $_GET['del'];
            $sql1="Delete from events where id='$id'";
            mysqli_query($conn,$sql1);
        }

        $sql="select * from events";
        $res= mysqli_query($conn,$sql);

        while($r= mysqli_fetch_assoc($res)) {
        ?>
            <tr>
                <td><?php echo $r["id"]; ?></td>
                <td><?php echo $r["event_name"]; ?></td>
                <td><?php echo $r["event_date"]; ?></td>
                <td><?php echo $r["event_details"]; ?></td>
                <td><?php echo $r["posted_by"]; ?></td>
                <center>
                <td><button type="submit" name="del" value="<?php echo $r["id"]; ?>">Delete</button></td>
                </center>
            </tr>
        <?php } ?>
        </table>
        </form>
    </div>
</body>
</html>
