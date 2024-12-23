<?php include "includes/header.php"; ?>

<?php

$product = $_SESSION['product'];
$quantity =  $_SESSION['quantity'];
$customer_name = $_SESSION['customer_name'];
$customer_address = $_SESSION['customer_address'];
$customer_contact_number = $_SESSION['customer_contact_number'];
$customer_email = $_SESSION['customer_email'];
$total_price =  $_SESSION['total_price'];
$unit_price = $_SESSION['unit_price'];
$seller = $logged_in_user['name'];





if (isset($_POST['submit'])) {


    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_SPECIAL_CHARS);


    $sql = "INSERT INTO sales (product, quantity, customer_name, customer_address, customer_contact_number, customer_email, price, payment_method, seller) VALUES ('$product', '$quantity', '$customer_name', '$customer_address' , '$customer_contact_number', '$customer_email', '$total_price', '$payment_method', '$seller' )";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo "Error " . mysqli_query($conn, $sql);
    }


}
?>


<div class="main-ctn">

    <div class="main-title-ctn">
        <h2 class="main-title">Sale Form</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>
    <div class="new-sale-form-ctn">

        <form action="" class="new-sale-form" method="POST">


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

            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn one-field-form-inputs-main-ctn">
                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="product">Payment Type</label>
                        <select type="text" class="new-sale-form-input" name="payment_method" placeholder="Enter product">
                            <option value="Back Transfer">Back Transfer</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                </div>
                <div class="new-sale-form-submit-ctn">
                    <a href="payment-form.php">
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Submit">
                    </a>
                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>