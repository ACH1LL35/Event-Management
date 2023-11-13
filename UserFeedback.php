<!DOCTYPE html>
<html>
<head>
    <div><title>Feedback History</title></div>
    <style>
        /* Style for the body */
            body {
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            /* Style for the h1 header */
            h1 {
                text-align: center;
                background-color: #333;
                color: #fff;
                padding: 10px;
            }

            /* Style for the table */
            table {
                width: 80%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            /* Style for table headers */
            th {
                background-color: #333;
                color: #fff;
                font-weight: bold;
                padding: 10px;
            }

            /* Style for table cells */
            td {
                padding: 8px;
                text-align: center;
            }

            /* Style for table rows */
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #ddd;
            }
    </style>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT q_id, q_title, q_des, q_fed FROM query WHERE u_id = '$id'
              UNION
              SELECT qo_id, qo_about, qo_des, qo_fed FROM quotation WHERE u_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h1>Feedback History</h1>";
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Title</th>
                <th>Details</th>
                <th>Feedback</th>
              </tr>";

              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['q_id'] . (isset($row['qo_id']) ? $row['qo_id'] : "") . "</td>
                        <td>" . $row['q_title'] . (isset($row['qo_about']) ? $row['qo_about'] : "") . "</td>
                        <td>" . $row['q_des'] . (isset($row['qo_des']) ? $row['qo_des'] : "") . "</td>
                        <td>" . $row['q_fed'] . (isset($row['qo_fed']) ? $row['qo_fed'] : "") . "</td>
                      </tr>";
            }
            
        echo "</table>";
    } else {
        echo "No data history available.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
