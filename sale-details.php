<?php include "includes/header.php";

if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Accountant" || $logged_in_user['role_name'] ===  "Sale Agent") {
    if (isset($_SESSION['id'])) {

        $id = $_SESSION['id'];

        $stmt = $conn->prepare("SELECT * FROM sales LEFT JOIN payment_methods on sales.method_id = payment_methods.method_id LEFT JOIN users on sales.seller_id = users.user_id  WHERE  sale_id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $sale = $result->fetch_assoc();


        $stmt = $conn->prepare('SELECT * FROM sale_items left join products on sale_items.product_id  = products.product_id where sale_id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $sale_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        echo 'Failed';
    }
} else {

    header("Location: restriction-page.php");
}
?>


<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title">Sale Details</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>
    <div class="sale-details-main-ctn">

        <div class="sale-details-gen-info-ctn">
            <div class="sale-details-gen-info-ctn-title">Sale Infomation</div>


            <div class="sale-info">
                <strong>Id: </strong>
                <?php echo $sale['sale_id']; ?>
            </div>


            <div class="sale-info">
                <strong>Sold by: </strong>
                <?php echo $sale['name']; ?>
            </div>


            <div class="sale-info">
                <strong>Date: </strong>
                <?php echo $sale['sold_on']; ?>


            </div>

            <div class="sale-info">
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
                            Quantity
                        </th>
                        <th>
                            Total Price
                        </th>
                    </tr>


                    <?php foreach ($sale_items as $sale_item): ?>
                        <tr class="sale-row">
                            <td><?php echo  $sale_item['product_name']; ?></td>
                            <td> NGN <?php echo  number_format($sale_item['piece_price'], 2); ?></td>
                            <td> NGN <?php echo  number_format($sale_item['wrap_pack_price'], 2); ?></td>
                            <td><?php echo  $sale_item['quantity']; ?></td>
                            <td> NGN <?php echo  number_format((($sale_item['wrap_pack_price']) * ($sale_item['quantity'])), 2); ?></td>



                        </tr>

                    <?php endforeach; ?>

                </table>


            </div>

            <div class="sale-info">
                <strong>Total Price : </strong>

                NGN <?php echo number_format($sale['payment_amount'], 2); ?>


            </div>


        </div>

        <div class="sale-details-gen-info-ctn">
            <div class="sale-details-gen-info-ctn">
                <div class="sale-details-gen-info-ctn-title">Customer Infomation</div>


                <div class="sale-info">
                    <strong>name: </strong>

                    <?php echo $sale['customer_name']; ?>

                </div>


                <div class="sale-info">
                    <strong>Address: </strong>

                    <?php echo $sale['customer_address']; ?>



                </div>

                <div class="sale-info">
                    <strong> Contact Number: </strong>

                    <?php echo $sale['customer_phone']; ?>


                </div>

                <div class="sale-info">
                    <strong> Email Address: </strong>

                    <?php echo $sale['customer_email']; ?>


                </div>




            </div>

            <div class="sale-details-gen-info-ctn">
                <div class="sale-details-gen-info-ctn-title">Payment Infomation</div>


                <div class="sale-info">
                    <strong>Method: </strong>

                    <?php echo $sale['method_name']; ?>


                </div>


                <div class="sale-info">
                    <strong>Amount Paid: </strong>

                    NGN <?php echo number_format($sale['payment_amount'], 2); ?>


                </div>

                <div class="sale-info">
                    <strong>Payment Status: </strong>

                    <?php echo $sale['completed']? "Complete" : "In Complete"; ?>


                </div>

                <div class="sale-info">
                    <strong> Date: </strong>

                    <?php echo $sale['sold_on']; ?>


                </div>

                <div>
                    <a href="receipt.php?sale_id=<?php echo $sale['sale_id']; ?>&page=sale_details">
                        <button class="btn">Open receipt</button>
                    </a>
                </div>

            </div>
        </div>


    </div>
</div>


<?php include 'includes/footer.php'; ?>