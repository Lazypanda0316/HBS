<?php 

session_start();
if(!isset($_SESSION['UNAME'])) {
    header("Location: login.php");
    exit();
}

// Include database connection file
include "connection.php";

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in username
$username = $_SESSION['UNAME'];

// Retrieve bookings data from the database for the logged-in user
$sql = "SELECT * FROM bookings b
        INNER JOIN roomtype rt ON rt.RTID = b.RTID 
        INNER JOIN customer c ON c.CID = b.CID
        WHERE c.name = ?
";
$stmt = mysqli_prepare($conn, $sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Error preparing the SQL statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    die("Error executing SQL query: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link href="css/mybooking.css" rel="stylesheet">
    
</head>
<body>
    <header>
        <?php include "navigation.php"; ?>
    </header>

    <div class="container">
        <h2>View Bookings</h2>
        <?php if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Room Type</th>
                <th>Room Price</th>
                <th>Total Days</th>
                <th>Total Price</th>
                <th>Time Left</th>
                <th>Action</th>
            </tr>
            <?php
            // Initialize counter
            $counter = 1;
            // Fetch and display each booking
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$counter}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['check_in_date']}</td>";
                echo "<td>{$row['check_out_date']}</td>";
                echo "<td>{$row['Rname']}</td>";
                echo "<td>{$row['Rprice']}</td>";
                
                // Calculate total days
                $checkInDate = new DateTime($row['check_in_date']);
                $checkOutDate = new DateTime($row['check_out_date']);
                $interval = $checkInDate->diff($checkOutDate);
                $totalDays = $interval->format('%a'); // Total days as integer
                echo "<td>{$totalDays}</td>";

                // Calculate total price
                $totalPrice = $row['Rprice'] * $totalDays;
                echo "<td>{$totalPrice}</td>";

                // Calculate time left
                $today = new DateTime();
                $interval = $today->diff($checkInDate);
                $timeLeft = $interval->format('%a days'); // Time left in days
                echo "<td>{$timeLeft}</td>";

                // Add the delete button
                echo "<td>
                        <form method='post' action='delete_booking.php'>
                            <input type='hidden' name='booking_id' value='{$row['id']}'>
                            <button type='submit'>Delete</button>
                        </form>
                      </td>";

                echo "</tr>";
                $counter++;
            }
            ?>
        </table>
        <?php } else { ?>
        <div class="no-bookings">
            <p><?php echo $username?> No bookings found. It looks like you haven't made any bookings yet. Please check back later or make a new booking.</p>
        </div>
        <?php } ?>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
