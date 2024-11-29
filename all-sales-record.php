<?php include "includes/header.php"; ?>


<?php

    
    $sales_sql = "SELECT * FROM sales ORDER BY id DESC";
    $result = mysqli_query($conn, $sales_sql);
    $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

    <div class="main-ctn">
        <h2 class="main-title">All Sales</h2>


        <div class="dashboard-recent-sale-ctn">
    
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
                        Price
                    </th>
                    
                </tr>


                <?php foreach ($sales as $sale): ?>
                <tr class="sale-row" data-id="<?php echo $sale['id']; ?>">
                    <td><?php echo $sale['id'];  ?></td>
                    <td><?php echo $sale['date'];  ?></td>
                    <td><?php echo $sale['customer_name'];  ?></td>
                    <td><?php echo $sale['price'];  ?></td>

                </tr>

                <?php endforeach; ?>

       </table>


        </div>

    </div>

    <?php include 'includes/footer.php'; ?>
