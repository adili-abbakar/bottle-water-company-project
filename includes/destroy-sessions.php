<?php 
    session_start();


        if (isset($_SESSION['unit_price'])){
            unset($_SESSION['unit_price']);
        }

        if (isset($_SESSION['product'])){
            unset($_SESSION['product']);
        }

        
        if(isset($_SESSION['quantity'])){
            unset($_SESSION['quantity']);
        }

        if(isset($_SESSION['customer_name'])){
            unset($_SESSION['customer_name']);
        }

        if(isset($_SESSION['customer_address'])){
            unset($_SESSION['customer_address']);
        }

        if(isset($_SESSION['customer_contact_number'])){
            unset($_SESSION['customer_contact_number']);
        }

        if(isset($_SESSION['customer_email'])){
            unset($_SESSION['customer_email']);
        }

        if(isset($_SESSION['total_price'])){
            unset($_SESSION['total_price']);
        }


    header('Location: /bwc/index.php ');
?>