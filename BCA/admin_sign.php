<?php
// Initialize variables
$name = $email = $address = $contact = $Password = $adminCode = $error = "";
$errors = []; // Define errors array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact']);
    $Password = trim($_POST['Password']);
    $adminCode = trim($_POST['adminCode']); // New code input

    // Validate inputs
    if (empty($name) || strlen($name) < 4) {
        $errors[] = "Name must have at least 4 characters";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if (empty($address) || strlen($address) < 5) {
        $errors[] = "Address must have at least 5 characters";
    }
    if (empty($contact) || !preg_match("/^98[0-9]{8}$/", $contact)) {
        $errors[] = "Contact should start with '98' and have 10 digits";
    }
    if (empty($Password) || strlen($Password) < 6 || !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $Password)) {
        $errors[] = "Password must have at least 6 characters and contain at least one special character";
    }
    if (empty($adminCode) || $adminCode !== 'admin') { // Replace 'SECRET_ADMIN_CODE' with the actual code
        $errors[] = "Invalid admin code";
    }

    // Handle form submission
    if (empty($errors)) {
        // Include your database connection file
        include("connection.php");

        // Query to admin database
        $sql = "INSERT INTO admin (name, email, address, contact, Password) VALUES ('$name', '$email', '$address', '$contact', '$Password')";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            // Redirect to login page after successful insertion
            header("Location: login.php");
            exit;
        } else {
            echo "Your Data cannot be inserted !!";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARC ANGEL - Admin Sign Up</title>
    <link href= "css/admin_sign.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Sign Up for ARC ANGEL (Admin)</h1>
        <form id="signupForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <?php if (!empty($errors) && in_array("Name must have at least 4 characters", $errors)) {
                echo "<p class='error'>Name must have at least 4 characters</p>";
            } ?>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            <?php if (!empty($errors) && in_array("Address must have at least 5 characters", $errors)) {
                echo "<p class='error'>Address must have at least 5 characters</p>";
            } ?>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <?php if (!empty($errors) && in_array("Valid email is required", $errors)) {
                echo "<p class='error'>Valid email is required</p>";
            } ?>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
            <?php if (!empty($errors) && in_array("Contact should start with '98' and have 10 digits", $errors)) {
                echo "<p class='error'>Contact should start with '98' and have 10 digits</p>";
            } ?>

            <label for="Password">Password:</label>
            <input type="password" id="Password" name="Password" required>
            <?php if (!empty($errors) && in_array("Password must have at least 6 characters and contain at least one special character", $errors)) {
                echo "<p class='error'>Password must have at least 6 characters and contain at least one special character</p>";
            } ?>

            <label for="adminCode">Admin Code:</label> <!-- New code input -->
            <input type="password" id="adminCode" name="adminCode" required>
            <?php if (!empty($errors) && in_array("Invalid admin code", $errors)) {
                echo "<p class='error'>Invalid admin code</p>";
            } ?>

            <input type="submit" value="Sign Up">
            <a class="admin-button" href="signin.php">Sign in as User</a>
        </form>
        
    </div>
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="errorContent"></div>
        </div>
    </div>

    <script>
        // Function to show error modal
        function showError(message) {
            var modal = document.getElementById('errorModal');
            var errorContent = document.getElementById('errorContent');
            errorContent.innerHTML = message;
            modal.style.display = 'block';

            // Close modal when close button or outside modal is clicked
            var closeBtn = document.getElementsByClassName('close')[0];
            window.onclick = function(event) {
                if (event.target == modal || event.target == closeBtn) {
                    modal.style.display = 'none';
                }
            };
        }

        // Display errors from PHP validation
        <?php if (!empty($errors)): ?>
            var errors = <?php echo json_encode($errors); ?>;
            errors.forEach(function(error) {
                showError(error);
            });
        <?php endif; ?>
    </script>
</body>
</html>
