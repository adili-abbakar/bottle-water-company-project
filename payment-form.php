<?php
include "includes/header.php";
if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Sale Agent") {

    $product_id = $_SESSION['product_id'];
    $product_quantity =  $_SESSION['product_quantity'];
    $customer_name = $_SESSION['customer_name'];
    $customer_address = $_SESSION['customer_address'];
    $customer_phone = $_SESSION['customer_contact_number'];
    $customer_email = $_SESSION['customer_email'];
    $customer_email = empty($customer_email) ? null : $customer_email;
    $total_price =  $_SESSION['total_price'];
    $unit_price = $_SESSION['unit_price'];
    $seller_id = $logged_in_user['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $payment_amount = ($product['wrap_pack_price'] * $product_quantity);

    $product_price_at_sale_time =  sprintf("%.2f", ($product['wrap_pack_price']));



    if (isset($_POST['submit'])) {


        $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_SPECIAL_CHARS);


        $stmt = $conn->prepare("INSERT INTO sales (customer_name, customer_email , customer_address, customer_phone, product_id ,product_quantity, product_price_at_sale_time, seller_id, payment_amount, payment_method) VALUES (?,?,?,?,?,?,?,?,?,?) ");

        if ($stmt) {



            $stmt->bind_param("ssssiidids", $customer_name, $customer_email, $customer_address, $customer_phone, $product_id, $product_quantity, $product_price_at_sale_time, $seller_id, $payment_amount, $payment_method);


            if ($stmt->execute()) {
                $sale_id = $conn->insert_id;
                $stmt = $conn->prepare("INSERT INTO reciepts (generated_date) values (DEFAULT)");
                $stmt->execute();
                $reciept_id = $conn->insert_id;
                $stmt = $conn->prepare("UPDATE sales set  reciept_id = ? where sale_id = ?");
                $stmt->bind_param('ii', $reciept_id, $sale_id);
                $stmt->execute();
                header(("Location: reciept.php?sale_id=$sale_id"));
            } else {
                echo "Error " . $stmt->error;
            }   
        } else {
            echo "ERROR PREPARING STATEMENT " . $conn->error;
        }
    }
} else {
    header("Location: restriction-page.php");
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
                    Product: <?php echo $product['product_name']; ?>
                </div>


                <div class="payment-inner-info-message">
                    <div>
                        Unit Price: NGN <?php echo number_format($product['wrap_pack_price'], 2);  ?>
                    </div>
                    <div>
                        Quantity: <?php echo $product_quantity; ?>
                    </div>
                </div>

                <div class="payment-inner-info-message">
                    Total Price: NGN <?php echo number_format($payment_amount, 2); ?>
                </div>
            </div>

            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn one-field-form-inputs-main-ctn">
                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="payment_type">Payment Type</label>
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