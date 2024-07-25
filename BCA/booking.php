<?php 
session_start();
if (!isset($_COOKIE['UNAME'])) {
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

// Fetch user details for the form
$username = $_SESSION["UNAME"];
$userrow = $conn->query("SELECT * FROM customer WHERE name='$username'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["CID"];
$useremail = $userfetch["email"];
$useraddress = $userfetch["address"];
$usercontact = $userfetch["contact"];

// Verify if $userid (CID) exists in customer table
$check_customer_query = "SELECT CID FROM customer WHERE CID = ?";
$stmt_check_customer = mysqli_prepare($conn, $check_customer_query);
mysqli_stmt_bind_param($stmt_check_customer, "i", $userid);
mysqli_stmt_execute($stmt_check_customer);
mysqli_stmt_store_result($stmt_check_customer);

if (mysqli_stmt_num_rows($stmt_check_customer) > 0) {
    // $userid exists in customer table, proceed with booking insertion
    if (isset($_POST['submit'])) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? validate($_POST['email']) : '';
        $contact = isset($_POST['contact']) ? validate($_POST['contact']) : '';
        $address = isset($_POST['address']) ? validate($_POST['address']) : '';
        $check_in_date = isset($_POST['check_in_date']) ? validate($_POST['check_in_date']) : '';
        $check_out_date = isset($_POST['check_out_date']) ? validate($_POST['check_out_date']) : '';
        $CID = isset($_POST['CID']) ? validate($_POST['CID']) : '';
        $RTID = isset($_POST['RTID']) ? validate($_POST['RTID']) : '';

        // Check if any field is empty
        if (empty($check_in_date) || empty($check_out_date) || empty($RTID) || empty($contact)) {
            $error_message = "All fields are required";
        } else {
            // Calculate total days
            $check_in = strtotime($check_in_date);
            $check_out = strtotime($check_out_date);
            $total_days = ($check_out - $check_in) / 86400; // Convert seconds to days

            // Fetch room price from database based on RTID
            $sql1 = "SELECT Rprice FROM roomtype WHERE RTID = ?";
            $stmt1 = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt1, "i", $RTID);
            mysqli_stmt_execute($stmt1);
            $result1 = mysqli_stmt_get_result($stmt1);

            if ($result1 && $result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                $Rprice = $row1["Rprice"]; // Get room price from fetched row
                // Calculate total price
                $total_price = $total_days * $Rprice;

                // Insert booking details into database using prepared statement
                $sql = "INSERT INTO bookings (email, contact, address, check_in_date, check_out_date, total_days, total_price, CID, RTID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssiiii", $email, $contact, $address, $check_in_date, $check_out_date, $total_days, $total_price, $userid, $RTID);
                mysqli_stmt_execute($stmt);

                // Check if insertion was successful
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    // Redirect to booking page with success message
                    header("Location: booking.php?success=Booking successful");
                    exit();
                } else {
                    // Database query error
                    $error_message = "Database query error: " . mysqli_error($conn);
                }
            } else {
                // Handle case where room type information is not found
                $error_message = "Room type information not found.";
            }
        }
    }
} else {
    // Handle case where $userid does not exist in customer table
    $error_message = "User ID not found or does not exist.";
}

// The rest of your HTML form and PHP code follows...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link href="css/booking.css" rel="stylesheet">
</head>
<body>
<?php include "navigation.php"; ?>
    <div class="container">
        <h2>Book Your Stay!!</h2>
        <?php 
            if (isset($error_message)) {
                echo '<div class="error">' . htmlspecialchars($error_message) . '</div>';
            }
            if (isset($_GET['success'])) {
                echo '<div class="success">' . htmlspecialchars($_GET['success']) . '</div>';
            }
        ?>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="CID" name="CID" value="<?php echo htmlspecialchars($userfetch['name']); ?>" placeholder="Enter your name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($useremail); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($useraddress); ?>" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($usercontact); ?>" required>
            
            <label for="check_in_date">Check-in Date:</label>
            <input type="date" id="check_in_date" name="check_in_date" value="<?php echo htmlspecialchars($check_in_date); ?>" required>

            <label for="check_out_date">Check-out Date:</label>
            <input type="date" id="check_out_date" name="check_out_date" value="<?php echo htmlspecialchars($check_out_date); ?>" required>

            <label for="room_type">Room Type:</label>
            <select id="RTID" name="RTID" required>
                <?php
                $list = $conn->query("SELECT * FROM roomtype");
                while ($row = $list->fetch_assoc()) {
                    $sn = $row["Rname"];
                    $id = $row["RTID"];
                    $pr = $row["Rprice"];
                    echo "<option value='$id'>$sn - Rs. $pr</option>";
                }
                ?>
            </select>

            <input type="submit" name="submit" value="Book Now">
        </form>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>
