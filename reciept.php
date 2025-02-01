<?php
include "includes/user-auth.php";
if ($_GET['sale_id']) {
  $sale_id = $_GET['sale_id'];
  $stmt = $conn->prepare('SELECT * FROM sales  left join  reciepts on sales.reciept_id = reciepts.reciept_id left join products on sales.product_id = products.product_id where sale_id = ? ');
  $stmt->bind_param('i', $sale_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $sale = $result->fetch_assoc();
} else {
  header("Location: all-sales-reord.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./static/styles/reciept.css">
  <title>BWC sale reciept</title>

</head>

<body>
  <div class="reciept-ctn">
    <div class="recipt-main-ctn">
      <div class="recipt-header">
        <h3>Recipt</h3>
        <h5>Bottle Water Company</h5>
      </div>
      <div class="reciept-body">
        <div class="reciept-body-top-ctn">
          <p>
            <strong>Customer</strong>
          </p>
          <div class="reciept-body-top-inner-ctn">
            <div>Name: <?php echo obscureName($sale['customer_name']) ?></div>
            <div>email: <?php echo $sale['customer_email'] ? obscureEmail($sale['customer_email']): '' ;  ?></div>
            <div>phone: <?php echo obscureName($sale['customer_phone']) ?></div>
            <div>Address: Kofar Marke, area</div>
          </div>
        </div>
        <div class="reciept-table-ctn">
          <p><strong>Items Bought</strong></p>

          <table class="recipt-items-table">
            <thead class="reciept-table-head">
              <th>Item</th>
              <th>Quantity</th>
              <th>Unit price</th>
              <th>Total Price</th>
            </thead>
            <tbody>
              <tr class="reciept-table-body-row">
                <td><?php echo $sale['product_name']; ?></td>
                <td><?php echo $sale['product_quantity']; ?></td>
                <td>NGN <?php echo number_format($sale['wrap_pack_price'], 2); ?></td>
                <td>NGN <?php echo number_format($sale['payment_amount'], 2); ?></td>
              </tr>


            </tbody>
          </table>
        </div>

        <div class="reciept-body-middle-ctn">
          <div class="recipt-total-ctn">Total: NGN <?php echo number_format($sale['payment_amount'], 2); ?>
          </div>
        </div>
        <div class="reciept-body-bottom-ctn">
          <p><strong>Payment Info</strong></p>
          <div class="reciept-body-bottom-inner-ctn">
            <div>Payment Method: <?php echo $sale['payment_method']; ?></div>
            <div>Amouny Paid: NGN <?php echo number_format($sale['payment_amount'], 2); ?></div>
            <div>Payment date: <?php echo $sale['sold_on']; ?></div>
            <div>Recipt generation date: <?php echo $sale['generated_date']; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="reciept-page-navigation-btns-ctn">
    <?php if($_GET['page'] !== 'payment_form'): ?>
    <button class="btn" onclick="window.history.back()">Back</button>
    <?php endif; ?>
    <a href="./all-sales-record.php"><button class="btn">Sales Record</button></a>

  </div>
</body>

</html>