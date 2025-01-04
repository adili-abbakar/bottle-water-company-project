<?php
include "includes/header.php";

$stmt = $conn->prepare("SELECT *  FROM sales ORDER BY sale_id DESC  LIMIT 6");
$stmt->execute();
$result = $stmt->get_result();
$sales = $result->fetch_all(MYSQLI_ASSOC);


$stmt = $conn->prepare('SELECT *  FROM products');
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="main-ctn">
    <h2 class="main-title">Dashboard</h2>

    <div class="dashboard-navigation-links">
        <a href="new-sale-form.php "><button class="btn"> + New Sale</button></a>
        <a href="all-sales-record.php"> <button class="btn"> All Sales Record</button></a>
        <a href="products-management.php"> <button class="btn"> Products Managment</button></a>
        <a href="users-management.php"> <button class="btn"> Users Management</button></a>



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
            </tr>


            <?php foreach ($products as $product): ?>
                <tr class="sale-row">
                    <td><?php echo  $product['product_name']; ?></td>
                    <td> NGN <?php echo  $product['piece_price']; ?></td>
                    <td> NGN <?php echo  $product['wrap_pack_price']; ?></td>


                </tr>

            <?php endforeach; ?>

        </table>


    </div>

    <div class="dashboard-recent-sale-ctn">

        <h3>Recent Sales</h3>
        <table class="table sale-table">
            <tr class="table-head">
                <th>
                    Sale ID
                </th>
                <th>
                    Date
                </th>
                <th>
                    Customer Name
                </th>
                <th>
                    Amount Paid
                </th>

            </tr>


            <?php foreach ($sales as $sale): ?>
                <tr class="sale-row" data-id="<?php echo $sale['sale_id']; ?>">
                    <td><?php echo $sale['sale_id'];  ?></td>
                    <td><?php echo $sale['sold_on'];  ?></td>
                    <td><?php echo $sale['customer_name'];  ?></td>
                    <td><?php echo $sale['payment_amount'];  ?></td>

                </tr>

            <?php endforeach; ?>

        </table>


    </div>


</div>


<?php include 'includes/footer.php'; ?>