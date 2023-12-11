<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Event Posting</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            margin: 0;
        }

        #sidebar {
            width: 250px;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        #event-form {
            max-width: 500px;
            margin: 0 auto; /* Center the form */
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            height: 350px;

        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-left: 10px;
        }

        button[type="submit"] {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <?php include("ModSidebar.php"); ?>
    </div>
    <div id="content">
        <h1>Mod - Event Posting</h1>
        <form id="event-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event-name">
            <br>
            <label for="event-date">Event Date:</label>
            <input type="date" id="event-date" name="event-date">
            <br>
            <label for="event-description">Event Description:</label>
            <textarea id="event-description" name="event-description" rows="4"></textarea>
            <br>
            <button type="submit">Post Event</button>
        </form>
    </div>
</body>
</html>