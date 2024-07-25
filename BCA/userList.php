<?php
    include "connection.php";
?>
<?php 

session_start();
if(!isset($_SESSION['UNAME'])) {
    header("Location: login.php");
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:#fff;
            margin-top: 120px;
            background-color: #49494a;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: black;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-bookings {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include("adminnav.php") ?>
    <div class="container">
        <h2>User List</h2>
        <table>
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 1;
                    $sql = mysqli_query($conn, 'SELECT * FROM `customer`') or die('Query failed');
                    if (mysqli_num_rows($sql)) {
                        while ($fetch_user = mysqli_fetch_assoc($sql)) {
                            ?>
                            <tr>
                                <td><?php echo $index++; ?></td>
                                <td><?php echo $fetch_user['name']; ?></td>
                                <td><?php echo $fetch_user['email']; ?></td>
                                <td><?php echo $fetch_user['address']; ?></td>
                                <td><?php echo $fetch_user['contact']; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="5" class="no-bookings">No users found</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
