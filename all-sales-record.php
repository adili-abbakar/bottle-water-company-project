<?php
include "includes/header.php";

if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Accountant" || $logged_in_user['role_name'] ===  "Sale Agent")  {


$stmt = $conn->prepare("SELECT * FROM sales ORDER BY sale_id DESC");
$stmt->execute();
$result = $stmt->get_result();
$sales = $result->fetch_all(MYSQLI_ASSOC);


}else{
    header("Location: restriction-page.php");

}
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