<?php include('includes/header.php') ?>

<?php







$name = $nameErr = $piece_price = $piece_priceErr = $wrap_pack_price = $wrap_pack_priceErr =  '';


if ($_GET['action'] === "add") {

    if (isset($_POST['submit'])) {
        if (!empty($_POST['name'])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $nameErr = "Product Name Is required";
        }

        if (!empty($_POST['piece_price'])) {

            if (is_numeric($_POST['piece_price'])) {
                $piece_price = filter_input(INPUT_POST, 'piece_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            } else {
                $Piece_priceErr = "Piece Price Must be Numbers or decimal";
            }
        } else {
            $piece_priceErr = "Piece Price is required";
        }

        if (!empty($_POST['wrap_pack_price'])) {

            if (is_numeric($_POST['wrap_pack_price'])) {
                $wrap_pack_price = filter_input(INPUT_POST, 'wrap_pack_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            } else {
                $wrap_pack_priceErr = "Wrap Pack Price Must be Numbers or decimal";
            }
        } else {
            $wrap_pack_priceErr = "Wrap pack is required";
        }



        if (!empty($name) && !empty($piece_price) && !empty($wrap_pack_price)) {
            $sql = "INSERT INTO products (name, piece_price, wrap_pack_price) VALUES ('$name', '$piece_price', '$wrap_pack_price')";

            if (mysqli_query($conn, $sql)) {
                header("Location: /bottle_water_company_project/products-management.php");
            } else {
                echo "Invalid Query: " . mysqli_query($conn, $sql);
            }
        }
    }
} else {
    $id = $_GET['id'];


    $sql = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    $id = $product['id'];
    $name = $product['name'];
    $piece_price = $product['piece_price'];
    $wrap_pack_price = $product['wrap_pack_price'];

    echo " $id <br> $name <br> $piece_price <br> $wrap_pack_price ";


    if (isset($_POST['submit'])) {
        if (!empty($_POST['name'])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $nameErr = "Product Name Is required";
            $name = '';
        }

        if (!empty($_POST['piece_price'])) {

            if (is_numeric($_POST['piece_price'])) {
                $piece_price = filter_input(INPUT_POST, 'piece_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            } else {
                $Piece_priceErr = "Piece Price Must be Numbers or decimal";
                $piece_price = ''; 
            }
        } else {
            $piece_priceErr = "Piece Price is required";
            $piece_price = ''; 
        }

        if (!empty($_POST['wrap_pack_price'])) {

            if (is_numeric($_POST['wrap_pack_price'])) {
                $wrap_pack_price = filter_input(INPUT_POST, 'wrap_pack_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            } else {
                $wrap_pack_priceErr = "Wrap Pack Price Must be Numbers or decimal";
                $wrap_pack_price = '';
            }
        } else {
            $wrap_pack_priceErr = "Wrap pack is required";
            $wrap_pack_price = "";
        }



        if (empty($nameErr) && empty($piece_priceErr) && empty($wrap_pack_priceErr)) {
            $sql = "UPDATE products SET name = '$name', piece_price = '$piece_price', wrap_pack_price='$wrap_pack_price' WHERE id = '$id' ";

            if (mysqli_query($conn, $sql)) {
                header("Location: /bottle_water_company_project/products-management.php");

            } else {
                echo "Invalid Query: " . mysqli_query($conn, $sql);
            }
        }
    }
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
                        <input type="hidden" value="<?php $id;?>" name="id">
                    <?php endif; ?>


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="name">Name</label>
                        <input type="text" class="new-sale-form-input <?php echo $nameErr ? 'err-style' : null; ?>" name="name" placeholder="Enter Product name" value="<?php echo $name; ?>">
                        <span class="err-message"><?php echo $nameErr ? $nameErr : null; ?></span>

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

                    <a href="">
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Update">
                    </a>
                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>