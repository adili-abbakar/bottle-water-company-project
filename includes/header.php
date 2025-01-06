<?php
include 'config/database.php';
include 'functions.php';


session_start();
if (!isset($_SESSION['username'])) {


    header('Location: login-form.php');
} else {


    $username = $_SESSION['username'];


    $stmt = $conn->prepare("SELECT * FROM users left join roles on users.role_id = customer_id WHERE username =? ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $logged_in_user = $result->fetch_assoc();
    $role_id = $logged_in_user['role_id'];


    if (!empty($role_id)) {
        $stmt = $conn->prepare("SELECT * FROM users JOIN roles on  users.role_id = roles.customer_id  WHERE username =? ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    }
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
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/form.css">



    <title>BWC Sales Record.</title>
</head>

<body>

    <header>
        <div class="header-main-ctn">
            <h3 class="header-title">
                Bottle Water Company
            </h3>


            <div class="navigation-links">
                <a href="index.php">Home</a> /
                <?php echo ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Accountant" || $logged_in_user['role_name'] ===  "Sale Agent")  ? "<a href='all-sales-record.php'>Sales</a> /" : null;  ?>
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

