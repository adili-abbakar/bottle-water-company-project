<?php include('config/database.php'); ?>

<?php

if (isset($_GET['id']) && isset($_GET['page'])) {
    $id = $_GET['id'];
    $page = $_GET['page'];


    if ($page === 'products-management') {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    } elseif ($page === "users-management") {
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
    } elseif ($page === "role-delete") {
        $stmt = $conn->prepare("SELECT * FROM roles WHERE role_id=?");
    } elseif ($page === "method-delete") {
        $stmt = $conn->prepare("SELECT * FROM payment_methods WHERE method_id=?");
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $obj = $result->fetch_assoc();
} else {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    if ($page === 'products-management') {
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    } elseif ($page === "users-management") {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    } elseif ($page === "role-delete") {
        $stmt = $conn->prepare("DELETE FROM roles WHERE role_id=?");
    } elseif ($page === "method-delete") {
        $stmt = $conn->prepare("DELETE FROM payment_methods WHERE method_id=?");
    }

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            if ($page === 'products-management') {
                header('Location: products-management.php');
            } elseif($page === "users-management") {
                header('Location: users-management.php');
            }elseif ($page ==="role-delete" || $page === "method-delete"){
                header('Location: general-settings.php');

            }
        } else {
            echo "Error  "  . $stmt->error;
        }
    } else {
        echo "Error preparing statement " . $conn->error;
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/styles/form.css">
    <link rel="stylesheet" href="./static/styles/main.css">

    <title>BWC Remove.</title>
</head>

<body>
    <div class="form-main-ctn">

        <form action="" method="POST" class="form-ctn">
            <div class="form-header">
                Remove <?php echo $page === "products-management" ? "Product" : 'User'; ?>
            </div>
            <div class="form-body">

                <p>Are you sure you want to parmanently remove <span class="error-message"> "
                        <?php if ($page === 'products-management') {
                            echo $obj['product_name'];
                        } elseif ($page === "users-management") {
                            echo  $obj['name'];
                        } elseif ($page === "role-delete") {
                            echo  $obj['role_name'];
                        } elseif ($page === "method-delete") {
                            echo  $obj['method_name'];
                        }
                        ?>
                        " </span>?</p>
                <br>

                <div class="btns-ctn">
                    <button type="button" class="btn" onclick="window.history.back()">No, Go Back</button>
                    <input type="submit" class="btn" name="submit" value="Yes, Remove">

                </div>

            </div>

        </form>

    </div>
</body>

</html>