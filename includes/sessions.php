<?php 
    session_start();


    if (isset($_GET['id'])){
        $_SESSION['id'] =  $_GET['id'];

        
        header('Location: /bwc/sale-details.php ');
    }

?>