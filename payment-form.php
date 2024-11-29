<?php include "includes/header.php"; ?>

    <?php 
        session_start();

        $product = $_SESSION['product'];
        $quantity =  $_SESSION['quantity'];
        $customer_name = $_SESSION['customer_name'];
        $customer_address = $_SESSION['customer_address'];
        $customer_contact_number = $_SESSION['customer_contact_number'];
        $customer_email = $_SESSION['customer_email'];
        $total_price =  $_SESSION['total_price'];
        $unit_price = $_SESSION['unit_price'];





    if (isset($_POST['submit'])){

          
        $payment_method = $_POST['payment_method'];


        $sql = "INSERT INTO sales (product, quantity, customer_name, customer_address, customer_contact_number, customer_email, price, payment_method) VALUES ('$product', '$quantity', '$customer_name', '$customer_address' , '$customer_contact_number', '$customer_email', '$total_price', '$payment_method')";

        if (mysqli_query($conn, $sql)){
            header("Location: includes/destroy-sessions.php ");    
        }else{
            echo Error . mysqli_query($conn, $sql);
        }
    }
    ?>


    <div class="main-ctn">

        <div class="new-sale-form-ctn">

            <form action="" class="new-sale-form" method="POST">
                <div class="new-sale-form-title">
                    Sale Form
                </div>

                <div class="payment-form-inner-info">
                    <div class="payment-inner-info-message">
                        Product: <?php echo $product; ?>
                    </div>
                   

                    <div class="payment-inner-info-message">
                        Unit Price: NGN <?php echo $unit_price;  ?>
                    </div>

                    <div class="payment-inner-info-message">
                        Total Price: NGN <?php echo $total_price; ?>
                    </div>
                </div>

                <div class="new-sele-form-body">
                    <div class="new-sele-form-input-ctn">
                        <label class="new-sele-form-input-label" for="product">Payment Type</label>
                        <select type="text" class="new-sale-form-input" name="payment_method" placeholder="Enter product"> <option value="Back Transfer">Back Transfer</option>
                        <option value="Cash">Cash</option>
                        </select>   
                    </div>

                    <div class="new-sele-form-submit-ctn">
                       <a href="payment-form.php">
                        <input type="submit" name="submit"  class="new-sale-form-submit btn" value="Submit">
                       </a>
                    </div>

                    
                </div>

            </form>

        </div>

    </div>

<?php include 'includes/footer.php'; ?>

