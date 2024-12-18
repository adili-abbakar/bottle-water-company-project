<?php include "includes/header.php"; ?>

<?php
$product = $quantity = $customer_name = $customer_email  = $customer_contact_number =  $customer_address = '';
$productErr = $quantityErr = $customer_nameErr = $customer_emailErr  = $customer_contact_numberErr = $customer_addressErr = '';


$product_sql = "SELECT * FROM products";
$result = mysqli_query($conn, $product_sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {


    if (empty($_POST['product'])) {
        $productErr = "Product is required";
    } else {
        $product = $_POST['product'];
    }

    if (empty($_POST['quantity'])) {
        $quantityErr = "Quantity is required";
    } else {
        $quantity = $_POST['quantity'];
    }


    if (empty($_POST['customer_name'])) {
        $customer_nameErr = "Customer Name is required";
    } else {
        $customer_name = $_POST['customer_name'];
    }

    if (empty($_POST['customer_email'])) {
        $customer_emailErr = "Customer Email is required";
    } else {
        $customer_email = $_POST['customer_email'];
    }

    if (empty($_POST['customer_contact_number'])) {
        $customer_contact_numberErr = "Customer Contact Number is required";
    } else {
        $customer_contact_number = $_POST['customer_contact_number'];
    }


    if (empty($_POST['customer_address'])) {
        $customer_addressErr = "Customer Address is required";
    } else {
        $customer_address = $_POST['customer_address'];
    }








    if (empty($productErr) && empty($quantityErr) && empty($customer_nameErr) && empty($customer_emailErr) && empty($customer_contact_numberErr) && empty($customer_addressErr)) {

        foreach ($products as $item) {
            if ($item['name'] === $product) {
                $unit_price = $item['price'];
                $total_price = $unit_price * $quantity;
                $total_price = sprintf("%.2f", $total_price);
            }
        }

        $_SESSION['unit_price'] = $unit_price;

        $_SESSION['product'] = $product;
        $_SESSION['quantity'] = $quantity;
        $_SESSION['customer_name'] = $customer_name;
        $_SESSION['customer_address'] = $customer_address;
        $_SESSION['customer_contact_number'] = $customer_contact_number;
        $_SESSION['customer_email'] = $customer_email;
        $_SESSION['total_price'] = $total_price;

        header('Location: payment-form.php');
    }
}

?>

<div class="main-ctn">

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">
            <div class="new-sale-form-title">
                Sale Form
            </div>


            <div class="new-sale-form-body">
                <div class="new-sale-form-input-ctn">
                    <label class="new-sale-form-input-label" for="product">Product</label>


                    <select type="text" class="new-sale-form-input  <?php echo $productErr ? 'err-style' : null; ?>" name="product" placeholder="Enter product">

                        <?php foreach ($products as $item): ?>
                            <option value="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></option>
                        <?php endforeach; ?>


                    </select>


                    <span class="err-message"><?php echo $productErr ? $productErr : null; ?></span>

                </div>

                <div class="new-sale-form-input-ctn">
                    <label class="new-sale-form-input-label" for="quantity">Quantity (Wrap pack)</label>
                    <input type="number" class="new-sale-form-input <?php echo $quantityErr ? 'err-style' : null; ?> " name="quantity" placeholder="Enter quantity">
                    <span class="err-message"><?php echo $quantityErr ? $quantityErr : null; ?></span>

                </div>

                <div class="new-sale-form-input-ctn">
                    <label class="new-sale-form-input-label" for="customer_name">Customer Name</label>
                    <input type="text" class="new-sale-form-input  <?php echo $customer_nameErr ? 'errr-style' : null; ?>" name="customer_name" placeholder="Enter Customer Name">
                    <span class="err-message"><?php echo $customer_nameErr ? $customer_nameErr : null; ?></span>

                </div>

                <div class="new-sale-form-input-ctn">
                    <label class="new-sale-form-input-label" for="customer_email">Customer Email</label>
                    <input type="email" class="new-sale-form-input  <?php echo $customer_emailErr ? 'err-style' : null; ?>" name="customer_email" placeholder="Enter Customer Email">
                    <span class="err-message"><?php echo $customer_emailErr ? $customer_emailErr : null; ?></span>

                </div>

                <div class="new-sale-form-input-ctn">
                    <label class="new-sale-form-input-label" for="customer_contact_number">Customer Contact Number</label>
                    <input type="number" class="new-sale-form-input  <?php echo $customer_contact_numberErr ? 'err-style' : null; ?>" name="customer_contact_number" placeholder="Enter Customer Contact Number">
                    <span class="err-message"><?php echo $customer_contact_numberErr ? $customer_contact_numberErr : null; ?></span>

                </div>


                <div class="new-sale-form-input-ctn">
                    <label class="new-sale-form-input-label" for="customer_address">Customer Address</label>
                    <input type="text" class="new-sale-form-input  <?php echo $customer_addressErr ? 'err-style' : null; ?>" name="customer_address" placeholder="Enter Customer Addres">
                    <span class="err-message"> <?php echo $customer_addressErr ? $customer_addressErr : null; ?></span>

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