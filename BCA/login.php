    <?php
session_start();

// Redirect user if already logged in
if (isset($_SESSION['UNAME'])) {
    header('location: home.php');
    exit();
}

// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'bca_project');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user is an admin
    $adminQuery = "SELECT * FROM admin WHERE name='$name' AND password='$password'";
    $adminRes = mysqli_query($conn, $adminQuery);

    if ($adminRes && mysqli_num_rows($adminRes) > 0) {
        $row = mysqli_fetch_assoc($adminRes);
        $_SESSION['UNAME'] = $row['name'];
        setcookie('UNAME', $row['name'], time() + 60 * 60 * 24 * 30);

        // Regenerate session ID
        // session_regenerate_id(true);

        // Redirect to admin page
        header('location: admin.php');
        exit();
    } else {
        // Fetch user from database
        $query = "SELECT * FROM customer WHERE name='$name' AND password='$password'";
        $res = mysqli_query($conn, $query);

        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['UNAME'] = $row['name'];
            setcookie('UNAME', $row['name'], time() + 60 * 60 * 24 * 30);

            // Regenerate session ID
            // session_regenerate_id(true);

            // Redirect to home page
            header('location: home.php');
            exit();
        } else {
            echo '<script>
                        window.location.href = "login.php";
                        alert("Login failed. Invalid username or password!!");
                  </script>';
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARCH ANGEL - Home</title>
    <link href="CSS/login.css" rel="stylesheet">
    
</head>
<body>
<div class="container">
    <div class="header">
        <img src="images/acr.png" alt="logo">
        <h1>Welcome to ARCH ANGEL!</h1>
    </div>
    <div class="form-body">
        <p class="sub-text">Login with your details to continue.</p>
        <form action="" method="POST">
            <label for="name" class="form-label">Name: </label><br>
            <input type="text" name="name" class="input-text" placeholder="Username" required><br>
            <label for="password" class="form-label">Password: </label><br>
            <input type="password" name="password" class="input-text" placeholder="Password" required><br>
            <input type="submit" name="submit" value="Login" class="login-btn">
        </form>
        <p class="sub-text">Don't have an account? <a href="signin.php">Sign Up</a></p>
    </div>
</div>
<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> ARCH ANGEL. All rights reserved.</p>
</div>
</body>
</html>
