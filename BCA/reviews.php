<?php
// Include the file that contains the database connection
include("connection.php");

// Define variables and initialize with empty values
$name = $website_experience = $website_design = $check_in_out_process = "";
$name_err = $website_experience_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate website experience
    if (empty($_POST["website_experience"])) {
        $website_experience_err = "Please select your website experience.";
    } else {
        $website_experience = $_POST["website_experience"];
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($website_experience_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO reviews (name, website_experience, website_design, check_in_out_process) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_name, $param_website_experience, $param_website_design, $param_check_in_out_process);

            // Set parameters
            $param_name = $name;
            $param_website_experience = $website_experience;
            $param_website_design = $_POST["website_design"];
            $param_check_in_out_process = $_POST["check_in_out_process"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to thank you page
                header("location: viewreviews.php");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Review</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px; /* Adjusted container width */
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            color: #4a90e2;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, textarea, input {
            width: calc(100% - 22px); /* Adjusted width */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
        }
        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #357ab8;
        }
        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit a Review</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <span class="error-message"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Website Experience</label>
                <select name="website_experience">
                    <option value="" selected disabled>Select your website experience</option>
                    <option value="Positive">Positive</option>
                    <option value="Neutral">Neutral</option>
                    <option value="Negative">Negative</option>
                </select>
                <span class="error-message"><?php echo $website_experience_err; ?></span>
            </div>
            <div class="form-group">
                <label>Website Design Review</label>
                <textarea name="website_design"></textarea>
            </div>
            <div class="form-group">
                <label>Check-in/Check-out Process Review</label>
                <textarea name="check_in_out_process"></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Submit Review</button>
            </div>
        </form>
    </div>
</body>
</html>
