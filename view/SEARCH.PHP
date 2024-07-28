
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Example</title>
    <style>
        /* Styles for the search bar */
        #search-container {
            text-align: right;
            margin: 10px 0;
        }

        #search-container select,
        #search-container input[type="text"],
        #search-container input[type="submit"] {
            padding: 5px;
            margin-right: 10px;
        }

        /* Styles for the search results */
        #search-results {
            margin-top: 20px;
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #search-results th, #search-results td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        #search-results th {
            background-color: #007BFF;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Search bar and dropdown -->
    <form method="post" id="search-container">
        <label for="search-option">Search by:</label>
        <select name="search_option">
            <option value="id">ID</option>
            <option value="name">Name</option>
            <option value="username">Username</option>
            <!-- Add more options as needed -->
        </select>
        <input type="text" name="search_text" placeholder="Search...">
        <input type="submit" name="search" value="Search">
    </form>

    <!-- Search results table -->
    <?php
    if (isset($_POST['search'])) {
        $search_option = $_POST['search_option'];
        $search_text = $_POST['search_text'];

        $servername = "localhost";
        $username = "root";
        $pass = "";
        $dbname = "your_database_name"; // Change this to your actual database name
        $conn = new mysqli($servername, $username, $pass, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM your_table_name WHERE $search_option LIKE '%$search_text%'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            echo '<table id="search-results" border="1">';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Username</th>';
            // Add more table headers as needed
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($res)) {
                echo '<tr>';
                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . $row["name"] . '</td>';
                echo '<td>' . $row["username"] . '</td>';
                // Add more table data as needed
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No results found.</p>';
        }

        mysqli_close($conn);
    }
    ?>
</body>
</html>
