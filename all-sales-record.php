<?php
include "includes/header.php";


if (in_array($logged_in_user['role_name'], ["Admin", "Accountant", "Sale Agent"])) {
    $search_query = isset($_GET['search_query']) ? "%" . $_GET['search_query'] . "%" : '';
    $search_by = isset($get['search_by']) ? $get['search_by'] : '';


    if ($search_query) {
        $stmt = $conn->prepare("SELECT * FROM sales left join users on sales.seller_id = users.id left join products on sales.sale_id = products.product_id  where sale_id Like ? or sale_id like ? or customer_email like ? or customer_name like ? or customer_address like ? or customer_phone like ? or payment_amount like ? or payment_method like ? or product_name like ? or  name like ? or DATE_FORMAT(sold_on, '%d-%m-%y') LIKE ?  ORDER BY sale_id DESC");
        $stmt->bind_param('sssssssssss', $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query);
    } else {
        $stmt = $conn->prepare("SELECT * FROM sales  ORDER BY sale_id DESC");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $sales = $result->fetch_all(MYSQLI_ASSOC);


    $stmt = $conn->prepare("SELECT * FROM  sales WHERE DATE(sold_on) = CURDATE()");
    $stmt->execute();
    $result = $stmt->get_result();
    $current_day_sales = $result->fetch_all(MYSQLI_ASSOC);
    $daily_sales_balance = array_value_sum($current_day_sales, 'payment_amount');
    $daily_sales_count = count($current_day_sales);

    $stmt = $conn->prepare("SELECT * FROM  sales WHERE DATE_FORMAT(sold_on, '%y-%m') = DATE_FORMAT(CURDATE(), '%y-%m')");
    $stmt->execute();
    $result = $stmt->get_result();
    $current_month_sales = $result->fetch_all(MYSQLI_ASSOC);
    $monthly_sales_balance = array_value_sum($current_month_sales, 'payment_amount');
    $monthly_sales_count = count($current_month_sales);

    $stmt = $conn->prepare("SELECT * FROM  sales WHERE DATE_FORMAT(sold_on, '%y') = DATE_FORMAT(CURDATE(), '%y')");
    $stmt->execute();
    $result = $stmt->get_result();
    $current_year_sales = $result->fetch_all(MYSQLI_ASSOC);
    $yearly_sales_balance = array_value_sum($current_year_sales, 'payment_amount');
    $yearly_sales_count = count($current_year_sales);
} else {
    header("Location: restriction-page.php");
}
?>

<div class="main-ctn">

    <div class="main-title-ctn">
        <h2 class="main-title">Sales Record</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="dashboard-navigation-links">
        <a href="periodic-sale-total.php">
            <button class="btn">
                Periodic Sales
            </button>
        </a>

    </div>

    <div class="daily-sale-table">
        <table class="second-table">
            <thead class="second-table-head">
                <th></th>
                <th>Sales Count</th>
                <th>Total Income</th>
            </thead>
            <tbody class="second-table-body">
                <tr>
                    <th class="second-table-head second-table-body-head">Current Day sales</th>
                    <td class="second-table-data"><?php echo $daily_sales_count; ?></td>
                    <td class="second-table-data"><?php echo $daily_sales_balance;  ?></td>
                </tr>
                <tr>
                    <th class="second-table-head second-table-body-head">Current Month sales</th>
                    <td class="second-table-data"><?php echo $monthly_sales_count; ?></td>
                    <td class="second-table-data"><?php echo $monthly_sales_balance;  ?></td>
                </tr>
                <tr>
                    <th class="second-table-head second-table-body-head">Current Year sales</th>
                    <td class="second-table-data"><?php echo $yearly_sales_count; ?></td>
                    <td class="second-table-data"><?php echo $yearly_sales_balance;  ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="search-bar-ctn">
        <form method="get" name="searchbar">
            <input
                name="search_query"
                class="search-bar"
                type="search"
                placeholder="Search sale.." />
            <input class="search-bar-submit-btn" type="submit" name="submit" value="Search">
        </form>
    </div>






    <div class="dashboard-recent-sale-ctn">
        <?php if ($search_query): ?>
            <div class="searcb-bar-cancel-btn-ctn">
                <div class="search-result-title">Search Result</div><button onclick="window.history.back()" class="searcb-bar-cancel-btn">X</button>
            </div>
        <?php endif; ?>
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
                    <td><?php echo obscureName($sale['customer_name']);  ?></td>
                    <td><?php echo number_format($sale['payment_amount'], 2);  ?></td>

                </tr>

            <?php endforeach; ?>

        </table>


    </div>

</div>

<?php include 'includes/footer.php'; ?>