<?php

include 'user-auth.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/styles/main.css">
    <link rel="stylesheet" href="static/styles/form.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />


    <title>BWC Sales Record.</title>
</head>

<body class="main-body">

    <header>
        <div class="header-main-ctn">
            <h3 class="header-title">
                Bottle Water Company
            </h3>


            <div class="navigation-links">
                <a href="index.php">Home</a> /
                <?php echo ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Accountant" || $logged_in_user['role_name'] ===  "Sale Agent")  ? "<a href='all-sales-record.php'>Sales Record</a> /" : null;  ?>
                <?php echo ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Sale Agent") ? "<a href='new-sale-form.php'>New Sale</a> /" : null;  ?>
                <?php echo ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Inventory Manager") ? "<a href='products-management.php'>Products management</a> /" : null;  ?>

                <?php echo ($logged_in_user['role_name'] ===  "Admin") ? "<a href='users-management.php'>Users management</a> /" : null;  ?>



                <?php if (isset($_SESSION['username'])): ?>
                    <a href="profile.php">Profile</a>/

                    <a href="includes/logout.php">Logout</a>
                <?php else: ?>
                    <a href="login-form.php">Login</a>

                <?php endif; ?>





            </div>
        </div>
    </header>