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

    $stmt = $conn->prepare("SELECT * from sales");
    $stmt->execute();
    $result = $stmt->get_result();
    $sales = $result->fetch_all(MYSQLI_ASSOC);
} else {
    header('Location: restriction-page.php');
}
?>

<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title">General Sales Total</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="periodic-total-sales-ctn">
        <p><big><strong>Genaral Total</strong></big></p>
        <div>Total Transaction: <?php echo array_value_sum($sales, 'payment_amount'); ?></div>
        <div>Total Sales count: <?php echo count($sales); ?></div>

    </div>
    
    
    <?php foreach ($yearly_sales as $yearly_sale): ?>
        <div class="year-periodic-sale-ctn">
            <div class="year-periodic-sale-inner-ctn">
                <div>Year: <?php echo $yearly_sale['sale_date'];  ?></div>
                <div>Total Transaction: <?php echo number_format($yearly_sale['total_sales'], 2); ?></div>
                <div>Total Sales: <?php echo $yearly_sale['sale_count'] ?></div>
            </div>
            <div class="month-periodic-sale-ctn ">
                <?php foreach ($monthly_sales as $monthly_sale): ?>
                    <?php if (strpos($monthly_sale['sale_date'], $yearly_sale['sale_date']) === 0): ?>
                        <div class="periodic-sale-ctn">
                            <div class="month-periodic-sale-inner-ctn">
                                <div>Month: <?php echo $monthly_sale['formatted_date'];  ?></div>
                                <div>Total Transaction: <?php echo number_format($monthly_sale['total_sales'], 2); ?></div>
                                <div>Total Sales: <?php echo $monthly_sale['sale_count'] ?></div>
                            </div>
                            <?php foreach ($daily_sales as $daily_sale): ?>
                                <?php if (strpos($daily_sale['sale_date'], $monthly_sale['sale_date']) === 0): ?>
                                    <div class="day-periodic-sale-ctn day-periodic-sale-inner-ctn">
                                        <div>Day: <?php echo $daily_sale['formatted_date'];  ?></div>
                                        <div>Total Transaction: <?php echo number_format($daily_sale['total_sales'], 2); ?></div>
                                        <div>Total Sales: <?php echo $daily_sale['sale_count'] ?></div>

                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>




</div>

<?php include './includes/footer.php'; ?>