<?php include 'config/database.php' ; ?>


<?php
session_start();
if(!isset($_SESSION['user'])){


    header('Location: /bwc/login-form.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/sale-detail.css">
    <link rel="stylesheet" href="styles/all-sales-record.css">
    <link rel="stylesheet" href="styles/new-item-form.css">



    <title>BWC Sales Record.</title>
</head>

<body>

    <header>
        <div class="header-main-ctn">
            <h3 class="header-title">
                Bottle Water Company
            </h3>


            <div class="navigation-links">
                <a href="index.php">Home</a>
                <a href="all-sales-record.php">Sales</a>
                <a href="new-sale-form.php">New Sale</a>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="profile.php">Profile</a>

                    <a href="includes/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="login-form.php">Login</a>

                <?php endif; ?>






            </div>
        </div>
    </header>


