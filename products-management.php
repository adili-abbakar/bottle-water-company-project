<?php include "includes/header.php"; ?>

<?php
$stmt = $conn->prepare('SELECT *  FROM products');
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="main-ctn">

    <h2 class="main-title">Products Management</h2>

    <div class="dashboard-navigation-links">
        <a href="/bottle_water_company_project/products-form.php ?action=add"><button class="btn add-btn"> + New Product</button></a>

    </div>



    <div class="dashboard-recent-sale-ctn">

        <h3>Products</h3>
        <table class="table product-table">
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
                    Actions
                </th>

            </tr>


            <?php foreach ($products as $product): ?>
                <tr class="sale-row" data-id="<?php echo $sale['id']; ?>">
                    <td><?php echo  $product['product_name']; ?></td>
                    <td> NGN <?php echo  $product['piece_price']; ?></td>
                    <td> NGN <?php echo  $product['wrap_pack_price']; ?></td>

                    <td>
                        <div class="table-btns-ctn">
                            <a href="/bottle_water_company_project/products-form.php?id=<?php echo $product['product_id']; ?>&action=update&page=products-management"><button class="btn table-btns update-btn">Update</button></a>

                            <a href="remove.php?id=<?php echo $product['product_id']; ?>&page=products-management">
                                <button class="btn table-btns remove-btn">Remove</button>
                            </a>


                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>


    </div>



</div>


<?php include 'includes/footer.php'; ?>