<?php
session_start();

if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    header('Location: /bottle_water_company_project/login-form.php');
} else {
    echo 'User is not logged in';
}

exit();
