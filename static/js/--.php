<div class="periodic-sales-ctn">
    <?php foreach ($yearly_sales as $yearly_sale): ?>
        <div>Year: <?php echo $yearly_sale['sale_date']; ?> (Total Sales: <?php echo number_format($yearly_sale['total_sales']) . ", Count: " . $yearly_sale['sale_count']; ?>)
            <div style="padding: 10px;">
                <?php foreach ($monthly_sales as $monthly_sale): ?>
                    <?php if (strpos($monthly_sale['sale_date'], $yearly_sale['sale_date']) === 0): // Match year 
                    ?>
                        <div class="periodic-sales-ctn">
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