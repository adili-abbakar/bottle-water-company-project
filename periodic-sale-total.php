<?php
include 'includes/header.php';

if (in_array($logged_in_user['role_name'], ["Admin", "Accountant", "Sale Agent"])) {
    // Fetch daily sales
    $stmt = $conn->prepare("SELECT DATE_FORMAT(sold_on, '%Y-%m-%d') AS sale_date, DATE_FORMAT(sold_on, '%D %M, %Y') AS formatted_date, SUM(payment_amount) AS total_sales, COUNT(*) AS sale_count
        FROM sales
        GROUP BY sale_date
        ORDER BY sale_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $daily_sales = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch monthly sales
    $stmt = $conn->prepare("SELECT DATE_FORMAT(sold_on, '%Y-%m') AS sale_date, DATE_FORMAT(sold_on, '%M, %Y') AS formatted_date, SUM(payment_amount) AS total_sales, COUNT(*) AS sale_count
        FROM sales
        GROUP BY sale_date
        ORDER BY sale_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $monthly_sales = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch yearly sales
    $stmt = $conn->prepare("SELECT DATE_FORMAT(sold_on, '%Y') AS sale_date, SUM(payment_amount) AS total_sales, COUNT(*) AS sale_count
        FROM sales
        GROUP BY sale_date
        ORDER BY sale_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $yearly_sales = $result->fetch_all(MYSQLI_ASSOC);
} else {
    header('Location: restriction-page.php');
}
?>

<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title">Periodic Sales</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div style="border: 1px black solid; width: 100%; padding: 10px;">
        <?php foreach ($yearly_sales as $yearly_sale): ?>
            <div>Year: <?php echo $yearly_sale['sale_date']; ?> (Total Sales: <?php echo number_format($yearly_sale['total_sales']) .", Count: " . $yearly_sale['sale_count'] ; ?>)
                <div style="padding: 10px;">
                    <?php foreach ($monthly_sales as $monthly_sale): ?>
                        <?php if (strpos($monthly_sale['sale_date'], $yearly_sale['sale_date']) === 0): // Match year 
                        ?>
                            <div style="border: 1px black solid; padding: 10px; margin-bottom: 10px;">
                                Month: <?php echo $monthly_sale['formatted_date']; ?> (Total Sales: <?php echo number_format($monthly_sale['total_sales'], 2) . ", Count: " . $yearly_sale['sale_count']; ?>)
                                <div style="padding: 10px;">
                                    <?php foreach ($daily_sales as $daily_sale): ?>
                                        <?php if (strpos($daily_sale['sale_date'], $monthly_sale['sale_date']) === 0): // Match year and month 
                                        ?>
                                            <div style="padding-left: 10px;">
                                                Day: <?php echo $daily_sale['formatted_date']; ?> (Total Sales: <?php echo number_format($daily_sale['total_sales'], 2) . ", Count: " . $daily_sale['sale_count']; ?>)
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>


<!-- <div class="daily-sales-table">

        <h3>Daily Sales Totals</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Sales Count</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daily_sales as $sale): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                        <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                        <td><?php echo number_format($sale['total_sales'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



    <div class="daily-sales-table">
        <h3>Monthly Sales Totals</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly_sales as $sale): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                        <td><?php echo number_format($sale['total_sales'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="daily-sales-table">
        <h3>Yearly Sales Totals</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($yearly_sales as $sale): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                        <td><?php echo number_format($sale['total_sales'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> -->