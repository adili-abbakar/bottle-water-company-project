<?php
include "includes/header.php";

if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Accountant" || $logged_in_user['role_name'] ===  "Sale Agent") {


    $search_query = isset($_GET['search_query']) ? "%" . $_GET['search_query'] . "%" : '';

    $search_by = isset($get['search_by']) ? $get['search_by'] : '';

    


    if ($search_query) {
        $stmt = $conn->prepare("SELECT * FROM sales left join users on sales.seller_id = users.id left join products on sales.sale_id = products.product_id 
        where sale_id Like ? or
            sale_id like ? or
            customer_email like ? or
            customer_name like ? or
            customer_address like ? or
            customer_phone like ? or
            payment_amount like ? or
            payment_method like ? or
            product_name like ? or 
            name like ? or
            DATE_FORMAT(sold_on, '%Y-%m-%d') LIKE ?
         ORDER BY sale_id DESC");
        $stmt->bind_param('sssssssssss', $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query);
        $stmt->execute();
        $result = $stmt->get_result();
        $sales = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $stmt = $conn->prepare("SELECT * FROM sales  ORDER BY sale_id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $sales = $result->fetch_all(MYSQLI_ASSOC);
    }
} else {
    header("Location: restriction-page.php");
}
?>

<div class="main-ctn">
    <h2 class="main-title">All Sales</h2>

    <div class="search-bar-ctn">
        <form method="get">
            <input
                name="search_query"
                class="search-bar"
                type="text"
                placeholder="Search sale.." />

            <input class="search-bar-submit-btn" type="submit" name="submit" value="Search">
        </form>
        <div class="search-by">Search by Sale Id, Customer Name, Customer Email, Customer Phone, Amount Paid, Payment Method, Product Name, Seller Name or Sale Date using YYYY-MM-DD format</div>
    </div>



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