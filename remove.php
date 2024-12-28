<?php include('config/database.php'); ?>

<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
} else {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {

    $sql = "DELETE FROM products WHERE id=$id";


    if (mysqli_query($conn, $sql)) {
        mysqli_query($conn, $sql);
        header('Location: products-management.php');
    } else {
        echo "invlaid query" . mysqli_query($conn, $sql);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/general.css">

    <title>BWC Remove.</title>
</head>

<body>
    <div class="form-main-ctn">

        <form action="" method="POST" class="form-ctn">
            <div class="form-header">
                Remove <?php ?>
            </div>
            <div class="form-body">

                <p>Are you sure you want to parmanently remove <span class="error-message"> "<?php echo $product['name']; ?>" </span>?</p>
                <br>

                <div class="btns-ctn">
                    <butto class="btn" onclick="window.history.back()">No, Go Back</butto>
                    <input type="submit" class="btn" name="submit" value="Yes, Remove">

                </div>

            </div>

        </form>

    </div>
</body>

</html>