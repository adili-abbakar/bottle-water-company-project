<?php 
define('DB_HOST', 'localhost');
define('DB_USER', 'adeelee');
define('DB_PASS', 'Aa22822527#');
define('DB_NAME', 'btw');



$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME  );

if($conn->connect_error){
    die('CONNECTION FAILED' . $conn->connect_error);
}

?>