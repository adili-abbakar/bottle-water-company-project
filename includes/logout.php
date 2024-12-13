<?php 
    session_start();

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    header('Location: /bwc/login-form.php');
}else{
    echo 'User is not logged in';
}

    exit();
?>