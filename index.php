<?php include "includes/header.php"; ?>

<?php
    $sql = 'SELECT *  FROM sales ORDER BY id DESC  LIMIT 6';
    $result = mysqli_query($conn, $sql);
    $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);


    $sql = 'SELECT *  FROM products';
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

    <div class="main-ctn">
        <h2 class="main-title">Dashboard</h2>

        <div class="dashboard-navigation-links">
            <a href="new-sale-form.php "><button class="btn"> + New Sale</button></a>
           <a href="all-sales-record.php"> <button class="btn"> All Sales Record</button></a>
    

            

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
                <tr class="sale-row" data-id="<?php echo $sale['id']; ?>">
                    <td><?php echo  $product['name']; ?></td>
                    <td>  NGN <?php echo  $product['price']/12; ?></td>
                    <td>  NGN <?php echo  $product['price']; ?></td>


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
