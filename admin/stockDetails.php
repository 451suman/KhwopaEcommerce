<?php
include "./layout/header.php";
include "./layout/admin_session.php";

// Determine which stock details to fetch
if (isset($_GET['pid_stock_buy_btn'])) {
    $pid=$_GET['pid'];
    $result = selectStocksBUY($pid, $conn);
} elseif (isset($_GET['pid_stock_SELL_btn'])) {
    $pid=$_GET['pid'];
    $result = selectStocksSELL($pid, $conn);
} else {
    if(isset($_GET['pid_product_page'])){
            $pid=$_GET['pid'];
        $result = selectStocks($pid, $conn);
    }
   
}
?>

<!-- Form for BUY DETAIL -->
<form action="stockDetails.php" method="get">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <button type="submit" name="pid_stock_buy_btn" class="btn btn-warning form_btn_stock">BUY DETAIL</button>
</form>

<!-- Form for SELL DETAIL -->
<form action="stockDetails.php" method="get">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <button type="submit" name="pid_stock_SELL_btn" class="btn btn-success form_btn_stock">SELL DETAIL</button>
</form>

<form action="stockDetails.php" method="get">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <button type="submit" name="pid_product_page" class="btn btn-primary form_btn_stock">ALL DETAIL</button>
</form>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">SN</th>
            <th scope="col">Total Quantity</th>
            <th scope="col">Stock BUY/SELL</th>
            <th scope="col">Entry Date</th>
            <th scope="col">Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $inOutText = ($row['s_in_out'] == 0) ?
                    '<p style="color:red;font-size:20px;"><strong>BUY</strong></p>' :
                    '<p style="color:green;font-size:20px;"><strong>SELL</strong></p>';

                echo '
                <tr>
                    <th scope="row">' . htmlspecialchars($row['sid']) . '</th>
                    <td>' . htmlspecialchars($row['s_quantity']) . '</td>
                    <td>' . $inOutText . '</td>
                    <td>' . htmlspecialchars($row['s_entryDate']) . '</td>
                    <td>' . htmlspecialchars($row['s_productPrice']) . '</td>
                </tr>
                ';
            }
        } else {
            echo '<tr><td colspan="5">No stock details found.</td></tr>';
        }
        ?>
    </tbody>
</table>

<?php include "./layout/footer.php"; ?>
