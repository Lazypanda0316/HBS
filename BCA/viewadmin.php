<?php
session_start();
if (!isset($_SESSION['UNAME'])) {
    header("Location: login.php");
    exit();
}
// Include the file that contains the database connection
include("connection.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $website_experience = $_POST['website_experience'];
    $website_design = $_POST['website_design'];
    $check_in_out_process = $_POST['check_in_out_process'];

    // Insert the new review into the database
    $insert_query = "INSERT INTO reviews (name, website_experience, website_design, check_in_out_process) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $name, $website_experience, $website_design, $check_in_out_process);
    $stmt->execute();
    $stmt->close();
}

// Fetch all reviews
$query = "SELECT name, website_experience, website_design, check_in_out_process FROM reviews ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reviews</title>
    <style>

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            color: #4a90e2;
            margin-bottom: 20px;
        }
        .review {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .review:last-child {
            border-bottom: none;
        }
        .review h3 {
            margin: 0 0 5px;
            color: #4a90e2;
        }
        .review p {
            margin: 5px 0;
        }
        .form-container {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container input,
        .form-container textarea {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            padding: 10px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #357ab8;
        }
        .header-container {
            text-align: center;
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        .header-container h1 {
            font-size: 24px;
            color: #333;
        }
        .header-container p {
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include "adminnav.php"?>
    
    <div class="container">
        <div class="header-container">
            <h1>Customer Reviews</h1>
            <p>We value your feedback. Please leave a review to help us improve our services.</p>
        </div>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="review">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p><strong>Website Experience:</strong> ' . htmlspecialchars($row['website_experience']) . '</p>';
                echo '<p><strong>Website Design Review:</strong> ' . nl2br(htmlspecialchars($row['website_design'])) . '</p>';
                echo '<p><strong>Check-in/Check-out Process Review:</strong> ' . nl2br(htmlspecialchars($row['check_in_out_process'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No reviews found.</p>';
        }
        ?>

        
    </div>
</body>
</html>
