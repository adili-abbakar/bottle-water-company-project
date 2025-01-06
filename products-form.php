<?php
include('includes/header.php');

if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Inventory Manager") {

$product_name = $product_nameErr = $piece_price = $piece_priceErr = $wrap_pack_price = $wrap_pack_priceErr =  '';


if($_GET['action'] === "update"){
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id= ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    $product_id = $product['product_id'];
    $product_name = $product["product_name"];
    $piece_price = $product['piece_price'];
    $wrap_pack_price = $product['wrap_pack_price'];
}

if (isset($_POST['submit'])) {


    $product_name_validation = validateInput($_POST['product_name'], 'Product Name');
    $product_name = $product_name_validation['value'];
    $product_nameErr = $product_name_validation['error'];


    $piece_price_validation = validateInput($_POST['piece_price'], 'Piece Price');
    $piece_price = $piece_price_validation['value'];
    $piece_priceErr = $piece_price_validation['error'];

    $wrap_pack_price_validation = validateInput($_POST['wrap_pack_price'], 'Wrap Pack Price');
    $wrap_pack_price = $wrap_pack_price_validation['value'];
    $wrap_pack_priceErr = $wrap_pack_price_validation['error'];
}

if ($_GET['action'] === "add") {
    $action = $_GET['action'];
    if (isset($_POST['submit'])) {

        if (!empty($product_name) && !empty($piece_price) && !empty($wrap_pack_price)) {
            $stmt = $conn->prepare("INSERT INTO products (product_name, piece_price, wrap_pack_price) VALUES (?,?,?)");

            if ($stmt) {
                $stmt->bind_param('sss', $product_name, $piece_price, $wrap_pack_price);
                if ($stmt->execute()) {
                    header("Location: /bottle_water_company_project/products-management.php");
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Error preparing statement " . $conn->error;
            }
        }
    }
} else {
    $action = $_GET['action'];

    if (isset($_POST['submit'])) {


        if (empty($product_nameErr) && empty($piece_priceErr) && empty($wrap_pack_priceErr)) {

            $stmt = $conn->prepare("UPDATE products SET product_name = ?, piece_price = ?, wrap_pack_price = ? WHERE product_id= ?");

            if ($stmt) {
                $stmt->bind_param("sddi", $product_name, $piece_price, $wrap_pack_price, $product_id);
                if ($stmt->execute()) {
                    header("Location: /bottle_water_company_project/products-management.php");
                    exit();
                } else {
                    echo "Error " . $stmt->error;
                }
            } else {
                echo "Error preparing statement " . $conn->error;
            }
        }
    }
}

}else{
    header("Location: restriction-page.php");

}

?>




<div class="main-ctn">
    <div class="main-title-ctn">

        <?php if ($_GET['action'] === 'update') : ?>
            <h2 class="main-title">Update Product</h2>
        <?php else: ?>
            <h2 class="main-title">New Product</h2>
        <?php endif; ?>

        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">


            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn  one-field-form-inputs-main-ctn">

                    <?php if ($_GET['action'] === 'update'): ?>
                        <input type="hidden" value="<?php $product_id; ?>" name="product_id">
                    <?php endif; ?>


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="product_name">Name</label>
                        <input type="text" class="new-sale-form-input <?php echo $product_nameErr ? 'err-style' : null; ?>" name="product_name" placeholder="Enter Product name" value="<?php echo $product_name; ?>">
                        <span class="err-message"><?php echo $product_nameErr ? $product_nameErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="piece_price">Piece Price</label>
                        <input type="number" step="any" class="new-sale-form-input <?php echo $piece_priceErr ? 'err-style' : null; ?>" name="piece_price" placeholder="Enter Product Piece Price" value="<?php echo $piece_price; ?>">
                        <span class="err-message"><?php echo $piece_priceErr ? $piece_priceErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="wrap_pack_price">Wrap Pack Price</label>
                        <input type="number" step="any" class="new-sale-form-input <?php echo $wrap_pack_priceErr ? 'err-style' : null; ?>" name="wrap_pack_price" placeholder="Enter Product Wrap Pack Price" value="<?php echo $wrap_pack_price; ?>">
                        <span class="err-message"><?php echo $wrap_pack_priceErr ? $wrap_pack_priceErr : null; ?></span>

                    </div>

                </div>

                <div class="new-sale-form-submit-ctn">
                    <?php if ($action === "add"): ?>
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Create">
                    <?php else: ?>
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Update">
                    <?php endif ?>

                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>