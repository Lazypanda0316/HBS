<?php
session_start();
if (!isset($_COOKIE['UNAME'])) {
    header("Location: login.php");
    die();
}

// Include database connection file
include "connection.php";

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $bookingId = $_POST['booking_id'];

    // Prepare the SQL delete statement
    $sql = "DELETE FROM bookings WHERE id = ? AND name = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . mysqli_error($conn));
    }

    $username = $_COOKIE['UNAME'];
    mysqli_stmt_bind_param($stmt, "is", $bookingId, $username);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Booking deleted successfully.";
    } else {
        echo "Error deleting booking: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
header("Location: mybooking.php");
?>
