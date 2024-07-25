<?php
// Initialize variables
$name = $email = $address = $contact = $Password = $error = "";
$errors = []; // Define errors array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact']);
    $Password = trim($_POST['Password']);

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

    // Handle form submission
    if (empty($errors)) {
        // Include your database connection file
        include("connection.php");

        // Query to database
        $sql = "INSERT INTO customer (name, email, address, contact, Password) VALUES ('$name', '$email', '$address', '$contact', '$Password')";
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
    <title>ARC ANGEL - Sign Up</title>
    <!-- <link href="signin.css" rel="stylesheet"> -->
     <style>body {
    background-color: #f7f9fc;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    max-width: 500px;
    width: 100%;
    padding: 30px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    text-align: center;
}
h1 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: 600;
}
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}
label {
    font-weight: 500;
    margin-bottom: 5px;
    color: #555;
    align-self: flex-start;
}
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    color: #333;
    box-sizing: border-box;
    outline: none;
    transition: border 0.3s ease;
}
input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #007bff;
}
input[type="submit"],
.admin-button {
    background-color: #007bff;
    color: white;
    padding: 10px 1px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    margin-top: 10px;
    width: 100%;
}
input[type="submit"]:hover,
.admin-button:hover {
    background-color: #0056b3;
}
.admin-button {
    background-color: #007bff;
}
.admin-button:hover {
    background-color: #218838;
}
.error {
    color: red;
    margin-top: -10px;
    margin-bottom: 10px;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}
.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}</style>
</head>
<body>
    <div class="container">
        <h1>Sign Up for ARC ANGEL</h1>
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
                echo "<script>showError('Valid email is required')</script>";
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

            <input type="submit" value="Sign Up">
            <a class="admin-button" href="admin_sign.php">Sign in as Admin</a>
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
    </script>
</body>
</html>
