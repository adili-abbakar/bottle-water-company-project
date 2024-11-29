<?php include "includes/header.php"; ?>

<?php
    session_start();

    if(isset($_SESSION['id'])){

        $id = $_SESSION['id'];

        unset($_SESSION['id']);

        $sale_deatils_sql = "SELECT * FROM sales WHERE  id = '$id' ";
        $result = mysqli_query($conn, $sale_deatils_sql);
        $sale = mysqli_fetch_assoc($result);

        $product_name = $sale['product'];
        // echo $name;
        $sale_product = "SELECT * FROM products WHERE name = '$product_name' ";
        $result = mysqli_query($conn, $sale_product);
        $sale_product = mysqli_fetch_assoc($result);

    }else{
        echo 'Failed';
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
                    <?php echo $sale['id']; ?>
            </div>


            <div class="sale-info">
                <strong>Date: </strong>
                <?php echo $sale['date']; ?>


            </div>

            <div class="sale-info">
                <strong> Product: </strong>
                <?php echo $sale['product']; ?>


            </div>

            
            <div class="sale-info">
                <strong> Quantity: </strong>
                <?php echo $sale['quantity']; ?>


            </div>

            <div class="sale-info">
                <strong> Unit Price : </strong>

                NGN <?php echo $sale_product['price']; ?>


            </div>

            <div class="sale-info">
                <strong>Total Price : </strong>

                NGN <?php echo $sale['price']; ?>


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

                <?php echo $sale['customer_contact_number']; ?>


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
                <strong>Amount: </strong>

                NGN <?php echo $sale['price']; ?>


            </div>

            <div class="sale-info">
                <strong> Date: </strong>

                <?php echo $sale['date']; ?>


            </div>

        </div>


    </div>
</div>


<?php include 'includes/footer.php'; ?>