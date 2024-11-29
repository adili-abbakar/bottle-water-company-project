<?php 
    session_start();

    session_destroy();


    header('Location: /bwc/index.php ');
?>