<?php include "includes/header.php";

if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Accountant" || $logged_in_user['role_name'] ===  "Sale Agent") {
    if (isset($_SESSION['id'])) {

        $id = $_SESSION['id'];


        $stmt = $conn->prepare("SELECT * FROM sales LEFT JOIN products on sales.product_id = products.product_id LEFT JOIN users on sales.seller_id = users.id  WHERE  sale_id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $sale = $result->fetch_assoc();
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
                <strong> Product: </strong>
                <?php echo $sale['product_name']; ?>


            </div>


            <div class="sale-info">
                <strong> Quantity (wrap pack): </strong>
                <?php echo $sale['product_quantity']; ?>


            </div>

            <div class="sale-info">
                <strong> Unit Price : </strong>


                NGN <?php echo number_format($sale['product_price_at_sale_time'], 2); ?>


            </div>

            <div class="sale-info">
                <strong>Total Price : </strong>

                NGN <?php echo number_format($sale['payment_amount'], 2); ?>


            </div>


        </div>

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

                <?php echo $sale['payment_method']; ?>


            </div>


            <div class="sale-info">
                <strong>Amount Paid: </strong>

                NGN <?php echo number_format($sale['payment_amount'], 2); ?>


            </div>

            <div class="sale-info">
                <strong> Date: </strong>

                <?php echo $sale['sold_on']; ?>


            </div>

            <div>
                <a href="reciept.php?sale_id=<?php echo $sale['sale_id'] ;?>">
                    <button class="btn">Open Reciept</button>
                </a>
            </div>

        </div>


    </div>
</div>


<?php include 'includes/footer.php'; ?>