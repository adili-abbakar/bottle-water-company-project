<?php
include "includes/user-auth.php";

if ($_GET['sale_id']) {
  $sale_id = $_GET['sale_id'];
  $stmt = $conn->prepare('SELECT * FROM sales left join receipts on sales.receipt_id = receipts.receipt_id left join payment_methods on sales.method_id =  payment_methods.method_id where sale_id = ? ');
  $stmt->bind_param('i', $sale_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $sale = $result->fetch_assoc();



  $stmt =$conn->prepare('SELECT * from sale_items left join products on sale_items.product_id = products.product_id where sale_id = ? ');
  $stmt->bind_param("i", $sale_id);
  $stmt->execute();
  $sale_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

} else {
  header("Location: all-sales-reord.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./static/styles/receipt.css">
  <title>BWC sale receipt</title>

</head>

<body>
  <div class="receipt-ctn">
    <div class="recipt-main-ctn">
      <div class="recipt-header">
        <h3>Recipt</h3>
        <h5>Bottle Water Company</h5>
      </div>
      <div class="receipt-body">
        <div class="receipt-body-top-ctn">
          <p>
            <strong>Customer</strong>
          </p>
          <div class="receipt-body-top-inner-ctn">
            <div>Name: <?php echo obscureName($sale['customer_name']) ?></div>
            <div>email: <?php echo $sale['customer_email'] ? obscureEmail($sale['customer_email']) : '';  ?></div>
            <div>phone: <?php echo obscureName($sale['customer_phone']) ?></div>
            <div>Address: Kofar Marke, area</div>
          </div>
        </div>
        <div class="receipt-table-ctn">
          <p><strong>Items Bought</strong></p>

          <table class="recipt-items-table">
            <thead class="receipt-table-head">
              <th>Item</th>
              <th>Quantity</th>
              <th>Unit price</th>
              <th>Total Price</th>
            </thead>
            <tbody>
              <?php foreach($sale_items as $sale_item): ?>
              <tr class="receipt-table-body-row">
                <td><?php echo $sale_item['product_name']; ?></td>
                <td><?php echo $sale_item['quantity']; ?></td>
                <td>NGN <?php echo number_format($sale_item['wrap_pack_price'], 2); ?></td>
                <td>NGN <?php echo number_format((($sale_item['wrap_pack_price']) * ($sale_item['quantity'])), 2); ?></td>
              </tr>
                <?php endforeach; ?>

            </tbody>
          </table>
        </div>

        <div class="receipt-body-middle-ctn">
          <div class="recipt-total-ctn">Total: NGN <?php echo number_format($sale['payment_amount'], 2); ?>
          </div>
        </div>
        <div class="receipt-body-bottom-ctn">
          <p><strong>Payment Info</strong></p>
          <div class="receipt-body-bottom-inner-ctn">
            <div>Payment Method: <?php echo $sale['method_name']; ?></div>
            <div>Amouny Paid: NGN <?php echo number_format($sale['payment_amount'], 2); ?></div>
            <div>Payment date: <?php echo $sale['sold_on']; ?></div>
            <div>Recipt generation date: <?php echo $sale['generation_date']; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="receipt-page-navigation-btns-ctn">
    <?php if ($_GET['page'] !== 'payment_form'): ?>
      <button class="btn" onclick="window.history.back()">Back</button>
    <?php endif; ?>
    <a href="./all-sales-record.php"><button class="btn">Sales Record</button></a>

  </div>
</body>

</html>