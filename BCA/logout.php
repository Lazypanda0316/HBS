<?php
    session_start();
    setcookie('UNAME',$_SESSION['UNAME'],60);
    unset($_SESSION['UNAME']);
    header('location: login.php');
    die();
?>