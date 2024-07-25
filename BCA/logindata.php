
 <?php
    session_start();
    if(isset($_SESSION['UNAME']) || isset($_COOKIE['UNAME'])) {
        header('location: home.php');
        die();
    }

    $conn=mysqli_connect('localhost','root','','bca_project');
    if(isset($_POST['submit']))
    {
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $res=mysqli_query($conn,"select * from customer where name='$name' and password='$password'");
        if(mysqli_num_rows($res)> 0)
        {
            $row=mysqli_fetch_assoc($res);
            $_SESSION['UNAME']= $row['InameD'];
            setcookie('UNAME',$row['name'],time()+ 60*60*24*30);
            header('location: home.php');
            die();
        }
        else
        {
            echo  '<script>
                        window.location.href = "login.php";
                        alert("Login failed. Invalid username or password!!");
                    </script>';
        }
    }
?>  