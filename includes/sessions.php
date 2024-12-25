<?php
session_start();


if (isset($_GET['id'])) {
    $_SESSION['id'] =  $_GET['id'];


    header('Location: /bottle_water_company_project/sale-details.php ');
}
