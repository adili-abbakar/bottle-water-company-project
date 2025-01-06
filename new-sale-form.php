<?php
include "includes/header.php";

if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Sale Agent") {

    $product_id = $product_quantity = $customer_name = $customer_email  = $customer_contact_number =  $customer_address = '';
    $product_idErr = $product_quantityErr = $customer_nameErr = $customer_emailErr  = $customer_contact_numberErr = $customer_addressErr = '';


    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $result = $stmt->get_result();
    $product_ids = $result->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['submit'])) {



        $product_id_validation = validateInput($_POST['product_id'], "Product");
        $product_id = $product_id_validation['value'];
        $product_idErr = $product_id_validation['error'];

        $product_quantity_validation = validateInput($_POST['product_quantity'], "Quantity");
        $product_quantity = $product_quantity_validation['value'];
        $product_quantityErr = $product_quantity_validation['error'];

        $customer_name_validation = validateInput($_POST['customer_name'], "Customer Name");
        $customer_name = $customer_name_validation['value'];
        $customer_nameErr = $customer_name_validation['error'];


        $customer_email_validation = validateInput($_POST['customer_email'], "Customer Email");
        $customer_email = $customer_email_validation['value'];
        $customer_emailErr = $customer_email_validation['error'];


        $customer_contact_number_validation = validateInput($_POST['customer_contact_number'], "Customer Contact Number");
        $customer_contact_number = $customer_contact_number_validation['value'];
        $customer_contact_numberErr = $customer_contact_number_validation['error'];

        $customer_address_validation = validateInput($_POST['customer_address'], "Customer Address");
        $customer_address = $customer_address_validation['value'];
        $customer_addressErr = $customer_address_validation['error'];





        if (empty($product_idErr) && empty($product_quantityErr) && empty($customer_nameErr) && empty($customer_emailErr) && empty($customer_contact_numberErr) && empty($customer_addressErr)) {



            $_SESSION['unit_price'] = $unit_price;
            $_SESSION['product_id'] = $product_id;
            $_SESSION['product_quantity'] = $product_quantity;
            $_SESSION['customer_name'] = $customer_name;
            $_SESSION['customer_address'] = $customer_address;
            $_SESSION['customer_contact_number'] = $customer_contact_number;
            $_SESSION['customer_email'] = $customer_email;
            $_SESSION['total_price'] = $total_price;

            header('Location: payment-form.php');
        }
    }
} else {
    header("Location: restriction-page.php");
}

?>

<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title">New Sale</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">



            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn">

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="product_id">Product</label>


                        <select type="text" class="new-sale-form-input  <?php echo $product_idErr ? 'err-style' : null; ?>" name="product_id" placeholder="Enter product">

                            <option value="">--select product--</option>

                            <?php foreach ($product_ids as $item): ?>
                                <option value="<?php echo $item['product_id']; ?>" <?php echo ($product_id == $item['product_id']) ? 'selected' : ''; ?>>
                                    <?php echo $item['product_name']; ?>
                                </option>
                            <?php endforeach; ?>




                        </select>



                        <span class="err-message"><?php echo $product_idErr ? $product_idErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for='product_quantity'>Quantity (Wrap pack)</label>
                        <input type="number" class="new-sale-form-input <?php echo $product_quantityErr ? 'err-style' : null; ?> " name="product_quantity" value="<?php echo $product_quantity; ?>" placeholder="Enter quantity">
                        <span class="err-message"><?php echo $product_quantityErr ? $product_quantityErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="customer_name">Customer Name</label>
                        <input type="text" class="new-sale-form-input  <?php echo $customer_nameErr ? 'err-style' : null; ?>" name="customer_name" value="<?php echo $customer_name; ?>" placeholder="Enter Customer Name">
                        <span class="err-message"><?php echo $customer_nameErr ? $customer_nameErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="customer_email">Customer Email</label>
                        <input type="email" class="new-sale-form-input  <?php echo $customer_emailErr ? 'err-style' : null; ?>" name="customer_email" value=" <?php echo $customer_email; ?>" placeholder="Enter Customer Email">
                        <span class="err-message"><?php echo $customer_emailErr ? $customer_emailErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="customer_contact_number">Customer Contact Number</label>
                        <input type="number" class="new-sale-form-input  <?php echo $customer_contact_numberErr ? 'err-style' : null; ?>" name="customer_contact_number" value="<?php echo $customer_contact_number; ?>" placeholder="Enter Customer Contact Number">
                        <span class="err-message"><?php echo $customer_contact_numberErr ? $customer_contact_numberErr : null; ?></span>

                    </div>


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="customer_address">Customer Address</label>
                        <input type="text" class="new-sale-form-input  <?php echo $customer_addressErr ? 'err-style' : null; ?>" name="customer_address" value="<?php echo $customer_address; ?>" placeholder="Enter Customer Addres">
                        <span class="err-message"> <?php echo $customer_addressErr ? $customer_addressErr : null; ?></span>

                    </div>

                </div>

                <div class="new-sale-form-submit-ctn">
                    <a href="">
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Next">
                    </a>
                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>