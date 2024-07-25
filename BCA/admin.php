<?php 
session_start();
if(!isset($_COOKIE['UNAME'])) {
    header("Location: login.php");
    exit();
}

// Include database connection file
include "connection.php";

// Function to validate input data
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to calculate total days
function calculateTotalDays($check_in_date, $check_out_date) {
    $diff = strtotime($check_out_date) - strtotime($check_in_date);
    return abs(round($diff / 86400));
}

// Function to calculate total price
function calculateTotalPrice($conn, $rtid, $check_in_date, $check_out_date) {
    $sql = "SELECT Rprice FROM roomtype WHERE RTID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $rtid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $room_price = $row['Rprice'];
        $total_days = calculateTotalDays($check_in_date, $check_out_date);
        return $room_price * $total_days;
    }
    return 0; // Handle if room price not found or other error
}

// Update booking
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $check_in_date = validate($_POST['check_in_date']);
    $check_out_date = validate($_POST['check_out_date']);
    $room_type = validate($_POST['RTID']);

    $total_days = calculateTotalDays($check_in_date, $check_out_date);
    $total_price = calculateTotalPrice($conn, $room_type, $check_in_date, $check_out_date);

    // Update booking details in database
    $sql = "UPDATE bookings SET check_in_date=?, check_out_date=?, RTID=?, total_days=?, total_price=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssiii", $check_in_date, $check_out_date, $room_type, $total_days, $total_price, $id);
        mysqli_stmt_execute($stmt);

        // Redirect to admin page after updating
        header("Location: admin.php");
        exit();
    } else {
        // Database query error
        $error_message = "Database query error: " . mysqli_error($conn);
    }
}

// Delete booking
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Delete booking from database
    $sql = "DELETE FROM bookings WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        // Redirect to admin page after deleting
        header("Location: admin.php");
        exit();
    } else {
        // Database query error
        $error_message = "Database query error: " . mysqli_error($conn);
    }
}

// Retrieve bookings data from the database
$sql = "SELECT bookings.*, customer.name AS name, roomtype.Rname AS Rname 
        FROM bookings
        INNER JOIN customer ON customer.CID = bookings.CID
        INNER JOIN roomtype ON roomtype.RTID = bookings.RTID";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/background.jpg');
            background-size: cover;
            margin-top: 120px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        form {
            display: inline;
        }

        select, input[type="date"], input[type="text"] {
            width: auto;
            padding: 5px;
            margin: 5px;
        }

        button {
            padding: 6px 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
        <?php include "adminnav.php"?>
    <div class="container">
        <h2>Manage Bookings</h2>
        <?php if (!empty($error_message)) : ?>
            <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Room Type</th>
                <th>Total Days</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            <?php 
            $index = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $total_days = calculateTotalDays($row['check_in_date'], $row['check_out_date']);
                $total_price = "Rs. " . number_format($row['total_price']);
            ?>
            <tr>
                <td><?php echo $index++; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
                <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
                <td><?php echo htmlspecialchars($row['RTID']); ?></td>
                <td><?php echo htmlspecialchars($total_days); ?></td>
                <td><?php echo htmlspecialchars($total_price); ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <select id="RTID" name="RTID" required>
                            <?php
                            $rtid = $row['RTID'];
                            $sql_roomtypes = "SELECT * FROM roomtype";
                            $result_roomtypes = mysqli_query($conn, $sql_roomtypes);
                            while ($row_roomtype = mysqli_fetch_assoc($result_roomtypes)) {
                                $selected = ($rtid == $row_roomtype['RTID']) ? "selected" : "";
                                echo "<option value='{$row_roomtype['RTID']}' $selected>{$row_roomtype['Rname']}</option>";
                            }
                            ?>
                        </select>
                        <input type="date" name="check_in_date" value="<?php echo htmlspecialchars($row['check_in_date']); ?>">
                        <input type="date" name="check_out_date" value="<?php echo htmlspecialchars($row['check_out_date']); ?>">
                        <button type="submit" name="update">Update</button>
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
