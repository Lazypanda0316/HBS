<?php 
session_start();
if(!isset($_SESSION['UNAME'])){
    header("Location: login.php");
    die(); 
}
// else
// {
//     echo $_SESSION['UNAME'];
// }
?>
<?php
include("connection.php");
if (isset($_SESSION['UNAME'])) {
    if (isset($_POST['submit'])) {
        // Check if all required POST variables are set
        if (isset($_POST['name'], $_POST['email'], $_POST['contact'], $_POST['address'])) {
            // Get the new values from the form
            $name = $_POST['name'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];

            
            $sql = mysqli_query($conn,"SELECT * FROM customer WHERE name = '$name'");
            $row = mysqli_fetch_array($sql);
            $current_email = $row['email'];
            $current_contact = $row['contact'];



            // Check if the updated email or phone number is the same as the current one
            if (($email == $current_email || checkUniqueEmail($conn, $email)) &&
             ($contact == $current_contact || checkUniquePhoneNumber($conn, $contact))) {
                // Update the user information in the database
                $sql1 = mysqli_query($conn,"UPDATE `customer` SET name='$name', email='$email', contact='$contact',
                 address='$address' WHERE name='$name'");
                echo '<script>
                        alert("Profile updated successfully");
                      </script>';
            } else {
                if ($email != $current_email && !checkUniqueEmail($conn, $email)) {
                    echo '<script>
                            alert("Email already in use!!");
                          </script>';
                }
                if ($contact != $current_contact && !checkUniquePhoneNumber($conn, $contact)) {
                    echo '<script>
                            alert("Phone Number already in use!!");
                          </script>';
                }
            }
        } else {
            // Handle case where required POST variables are not set
            $message[] = "One or more required fields are missing.";
        }
    }
}

function checkUniqueEmail($conn, $email)
{
    $count = 0; // Initialize count
    $stmt = $conn->prepare("SELECT COUNT(*) FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    return $count == 0;
}

function checkUniquePhoneNumber($conn, $contact)
{
    $count = 0; // Initialize count
    $stmt = $conn->prepare("SELECT COUNT(*) FROM customer WHERE contact = ?");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    return $count == 0;
}
?>
<?php
    $query = "select * from customer";
    $run = mysqli_query($conn,$query); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashbord.css">
    
    
</head>
<body>
<div class="grid-container">

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <img src="images/acr.png" alt="logo">
        </div>
        <!-- <div class="menu-icon" onclick="openSidebar()">
            <span class="material-icons-outlined">menu</span>
        </div> -->
        <div class="header-right">
            <p><span class="material-icons-outlined">account_circle</span></p>
            <a><?php
                // Check if user is logged in
                echo "Hello, ".$_SESSION['UNAME'];
                ?></a>

        </div>
    </header>
    <main class="main-container">
        <a href="home.php"><-Back to Homepage</a>
        <div class="main-title">
            <h2>WELCOME TO USER DASHBOARD</h2>
        </div>

        <div class="editpro">
            <h2>EDIT PROFILE</h2>
        </div>
        <form action="" method="post" class="upform" onsubmit="return update()">
            <p>Name<br><br>
                <input type="text" name="name" value="<?php
                // Check if user is logged in
                echo $_SESSION['UNAME'];
                ?>" required></p>
            <p>Email<br><br>
                <input type="email" name="email" id="email" value="<?php
                // Check if user is logged in
                if(isset($_SESSION['UNAME'])) {
                    // Fetch and display user email
                    $name = $_SESSION['UNAME'];
                    $res=mysqli_query($conn,"SELECT email FROM customer WHERE name='$name'");
                    $row=mysqli_fetch_assoc($res);
                    $email = $row['email'];
                    echo $email;
                } else {
                    echo '<p>User not logged in.</p>';
                }
                ?>" required>
            </p>

            <p>Phone<br><br>
                <input type="number" name="contact" id="num" maxlength="10" value="<?php
                // Check if user is logged in
                if(isset($_SESSION['UNAME'])) {
                    // Fetch and display user email
                    $name = $_SESSION['UNAME'];
                    $res=mysqli_query($conn,"SELECT contact FROM customer WHERE name='$name'");
                    $row=mysqli_fetch_assoc($res);
                    $contact = $row['contact'];
                    echo $contact;
                } else {
                    echo '<p>User not logged in.</p>';
                }
                ?>"></p>
            <p>Address<br><br>
                <input type="text" name="address" value="<?php
                // Check if user is logged in
                if(isset($_SESSION['UNAME'])) {
                    // Fetch and display user email
                    $name = $_SESSION['UNAME'];
                    $res=mysqli_query($conn,"SELECT address FROM customer WHERE name='$name'");
                    $row=mysqli_fetch_assoc($res);
                    $address = $row['address'];
                    echo $address;
                } else {
                    echo '<p>User not logged in.</p>';
                }
                ?>" required></p>

            <br><input type="submit" name="submit" value="Update" id="upd">
        </form>
        
        

        <?php
            include("changePWuser.php");    
        ?>

     
    </main>
   

</div>

<script>
    document.getElementById('num').addEventListener('input', function (e) 
    {
        const value = e.target.value;
        if (!/^9[78]\d{8}$/.test(value)) 
        {
            e.target.setCustomValidity('Your number is not in proper format.');
        }
        else 
        {
            e.target.setCustomValidity('');
        }
    });

    document.getElementById('email').addEventListener('input', function (e) 
    {
        const value = e.target.value;
        if (!/^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+)\.([a-z]{2,20})(\.[a-z]{2,20})?$/.test(value)) 
        {
            e.target.setCustomValidity('Your email is not in proper format.');
        } 
        else 
        {
            e.target.setCustomValidity('');
        }
    });
</script>
</body>
</html>