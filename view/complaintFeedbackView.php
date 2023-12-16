<?php
include_once("../model/complaintFeedbackModel.php");

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include_once("../controller/complaintFeedbackController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMPLAINT FEEDBACK</title>
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
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">COMPLAINT FEEDBACK</h1>
        <form method="get">
            <table border="1">
                <tr>
                    <th>Complaint ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Description</th>
                    <th>Feedback</th>
                    <th>Feedback Given By</th>
                    <th>Action</th>
                </tr>
                <?php
                if (isset($_GET['del'])) {
                    $id = $_GET['del'];
                    deleteComplaint($id);
                }

                $sql = "SELECT * FROM complaint";
                $res = mysqli_query($conn, $sql);

                while ($r = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <td><?php echo $r["id"]; ?></td>
                        <td><?php echo $r["name"]; ?></td>
                        <td><?php echo $r["email"]; ?></td>
                        <td><?php echo $r["contact"]; ?></td>
                        <td><?php echo $r["description"]; ?></td>
                        <td><?php echo $r["feedback"]; ?></td>
                        <td><?php echo $r["fd_by"]; ?></td>
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
