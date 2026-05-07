<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: UserLogin");
    exit();
}

include 'includes/db.php';
$id = $_SESSION['id'];

// Fetch user data
$query = "SELECT * FROM credential WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $email = $row['email'];
    $name = $row['name'];
    $cnumber = $row['cnumber'];
}

function generateRandomString($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_name'])) {
    $event_name = $conn->real_escape_string($_POST["event_name"]);
    $ticket_quantity = intval($_POST["ticket_quantity"]);
    $selected_venue = $conn->real_escape_string($_POST["selected_venue"]);
    $show_id = $conn->real_escape_string($_POST["show_id"]);

    $sql = "SELECT available_tickets FROM ticket_cr WHERE event_name = '$event_name'";
    $res = $conn->query($sql);

    if ($res && $res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $available_tickets = $row["available_tickets"];

        if ($ticket_quantity <= $available_tickets) {
            $new_available_tickets = $available_tickets - $ticket_quantity;
            $update_sql = "UPDATE ticket_cr SET available_tickets = $new_available_tickets WHERE event_name = '$event_name'";

            if ($conn->query($update_sql) === TRUE) {
                $ticket_id = generateRandomString(10);
                $insert_sql = "INSERT INTO purchase_info (event_name, venue, ticket_quantity, contact_number, user_id, email, name, ticket_id, Showid) 
                               VALUES ('$event_name', '$selected_venue', $ticket_quantity, '$cnumber', $id, '$email', '$name', '$ticket_id', '$show_id')";

                if ($conn->query($insert_sql) === TRUE) {
                    $message = "Success! Tickets purchased. Ticket ID: $ticket_id";
                    $messageType = "success";
                } else {
                    $message = "Error saving purchase: " . $conn->error;
                    $messageType = "error";
                }
            }
        } else {
            $message = "Not enough tickets available.";
            $messageType = "error";
        }
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: UserLogin");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Tickets - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #1e293b;
        }

        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 40px;
        }

        .header-strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .header-strip h1 {
            font-size: 1.8rem;
            margin: 0;
            color: #0f172a;
        }

        .ticket-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            max-width: 600px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #475569;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #fff;
            box-sizing: border-box;
        }

        .btn-purchase {
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-purchase:hover {
            background-color: #1d4ed8;
        }

        .status-msg {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .logout-btn {
            padding: 8px 16px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
            color: #64748b;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <?php include 'includes/UserSidebar.php'; ?>

        <main class="main-content">
            <div class="header-strip">
                <h1>Purchase Tickets</h1>
                <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log Out</button>
                </form>
            </div>

            <?php if ($message): ?>
                <div class="status-msg <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="ticket-card">
                <form method="post">
                    <div class="form-group">
                        <label for="event_name">Select Event</label>
                        <select name="event_name" id="event_name" required>
                            <option value="" disabled selected>Choose an active event...</option>
                            <?php
                            $sql = "SELECT event_name, available_tickets, venue, Showid FROM ticket_cr";
                            $res = $conn->query($sql);
                            if ($res && $res->num_rows > 0) {
                                while ($row = $res->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row["event_name"]) . "' 
                                                  data-venue='" . htmlspecialchars($row["venue"]) . "' 
                                                  data-showid='" . htmlspecialchars($row["Showid"]) . "'>" 
                                                  . htmlspecialchars($row["event_name"]) . " (" . $row["available_tickets"] . " left)</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ticket_quantity">Quantity</label>
                        <input type="number" name="ticket_quantity" id="ticket_quantity" min="1" value="1" required>
                    </div>

                    <input type="hidden" id="selected_venue" name="selected_venue">
                    <input type="hidden" id="show_id" name="show_id">

                    <button type="submit" class="btn-purchase">Confirm Purchase</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('event_name').addEventListener('change', function() {
            var opt = this.options[this.selectedIndex];
            document.getElementById('selected_venue').value = opt.getAttribute('data-venue');
            document.getElementById('show_id').value = opt.getAttribute('data-showid');
        });
    </script>
</body>
</html>
