<?php
include "includes/header.php";
if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Sale Agent") {

    $product_ids = $_SESSION['product_ids'];
    $quantites = $_SESSION['quantities'];
    $customer_name = $_SESSION['customer_name'];
    $customer_email = $_SESSION['customer_email'];
    $customer_contact_number = $_SESSION['customer_contact_number'];
    $customer_address = $_SESSION['customer_address'];
    $seller_id = $logged_in_user['user_id'];
    $payment_amount = 0;

    $stmt = $conn->prepare("SELECT * FROM payment_methods");
    $stmt->execute();
    $result = $stmt->get_result();
    $payment_methods = $result->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['submit'])) {

        $stmt = $conn->prepare("INSERT INTO SALES (customer_name, customer_email, customer_phone, customer_address, seller_id, payment_amount ) values (?,?,?,?,?,?) ");
        $stmt->bind_param('ssssii', $customer_name, $customer_email, $customer_contact_number, $customer_address, $seller_id, $payment_amount);
        $stmt->execute();
        $sale_id = $conn->insert_id;



        for ($i = 0; $i < count($product_ids); $i++) {
            $product_id = $product_ids[$i];
            $quantity = $quantites[$i];

            $stmt = $conn->prepare("SELECT * FROM products where product_id = ?");
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $price = $product['wrap_pack_price'] * $quantity;
            $payment_amount += $price;

            $stmt = $conn->prepare("INSERT INTO sale_items (sale_id, product_id, quantity) VALUES (?,?,?)");
            $stmt->bind_param("iii", $sale_id, $product_id, $quantity);
            $stmt->execute();
        }



        $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_NUMBER_FLOAT);


        $stmt = $conn->prepare("UPDATE sales set payment_amount = ?, method_id = ?, completed = ? where sale_id = ? ");


        if ($stmt) {
            $payment_method = (int) $payment_method;
            $sale_id = (int) $sale_id;
            $completed = 1;
            $stmt->bind_param("diii", $payment_amount, $payment_method, $completed, $sale_id);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO receipts  (generation_date) value (DEFAULT)");
                $stmt->execute();
                $receipt_id = $conn->insert_id;
                $stmt = $conn->prepare("UPDATE sales set  receipt_id = ? where sale_id = ?");
                $stmt->bind_param('ii', $receipt_id, $sale_id);
                $stmt->execute();
            } else {
                echo "Error " . $stmt->error;
            }
        } else {
            echo "ERROR PREPARING STATEMENT " . $conn->error;
        }

        for ($i = 0; $i < count($product_ids); $i++) {
            $product_id = $product_ids[$i];
            $quantity = $quantites[$i];

            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            $stmt = $conn->prepare("INSERT INTO sale_items (product_id, quantity) VALUES (?,?)");
            $stmt->bind_param('ii', $product_id, $quantity);
            $stmt->execute();
        }

        header(("Location: receipt.php?sale_id=$sale_id&page=payment_form"));
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

        <div style="padding: 3px;">

            <table class="table product-table">
                <h3>Sale Items</h3>
                <tr class="table-head">
                    <th>
                        Product
                    </th>
                    <th>
                        Piece Price
                    </th>
                    <th>
                        Wrap pack Price
                    </th>

                    <th>
                        Quantity
                    </th>
                    <th>
                        Total Price
                    </th>
                </tr>

                <?php for ($i = 0; $i < count($product_ids); $i++): ?>
                    <?php
                    $product_id = $product_ids[$i];
                    $quantity = $quantites[$i];
                    $stmt = $conn->prepare("SELECT * from products where product_id = ?");
                    $stmt->bind_param('i', $product_id);
                    $stmt->execute();
                    $product = $stmt->get_result()->fetch_assoc();
                    $payment_amount += $product['wrap_pack_price'] * $quantity;

                    ?>

                    <tr class="sale-row">
                        <td><?php echo  $product['product_name']; ?></td>
                        <td> NGN <?php echo  number_format($product['piece_price'], 2); ?></td>
                        <td> NGN <?php echo  number_format($product['wrap_pack_price'], 2); ?></td>
                        <td> <?php echo  $quantity ?></td>
                        <td> NGN <?php echo  number_format(($product['wrap_pack_price'] * $quantity), 2); ?></td>



                    </tr>

                <?php endfor; ?>


            </table>
            <p style=" text-align: center; padding: 10px;"><strong>TOTAL PAYMENT:</strong> NGN <?php echo number_format($payment_amount, 2); ?></p>
        </div>

        <form action="" class="new-sale-form" method="POST">



            <div class="new-sale-form-body">

                <div class="new-sale-form-inputs-main-ctn one-field-form-inputs-main-ctn">
                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="payment_type">Payment Type</label>
                        <select type="text" class="new-sale-form-input" name="payment_method" placeholder="Enter product">
                            <?php foreach ($payment_methods as $payment_method): ?>
                                <option value="<?php echo $payment_method['method_id'] ?>"><?php echo $payment_method['method_name'] ?></option>
                            <?php endforeach; ?>
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