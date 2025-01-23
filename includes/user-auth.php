<?php

include 'config/database.php';
include 'functions.php';


session_start();
if (!isset($_SESSION['username'])) {


    header('Location: login-form.php');
} else {


    $username = $_SESSION['username'];


    $stmt = $conn->prepare("SELECT * FROM users left join roles on users.role_id = user_id WHERE username =? ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $logged_in_user = $result->fetch_assoc();
    $role_id = $logged_in_user['role_id'];


    if (!empty($role_id)) {
        $stmt = $conn->prepare("SELECT * FROM users JOIN roles on  users.role_id = roles.user_id  WHERE username =? ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
