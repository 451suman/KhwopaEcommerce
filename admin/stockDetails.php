<?php
include "./layout/header.php";
include "./layout/admin_session.php";



// Determine which stock details to fetch
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];  // Get product ID erither from products.php,(buy,sell,All)  detail buttonm 
} else {
    echo '<tr><td colspan="5">No product ID provided.</td></tr>';
    exit;
}

// Display stock details if applicable
if (isset($_GET['pid_stock_buy_btn'])) { //when buy btn is clicked
    $result = selectStocksBUY($pid, $conn);
} elseif (isset($_GET['pid_stock_SELL_btn'])) { //when buy sell is clicked
    $result = selectStocksSELL($pid, $conn);
} elseif (isset($_GET['pid_product_page'])) { // pid comes from product page ko View AND when aall button is clicked
    $result = selectStocks($pid, $conn);
}

// Display product details
if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch product details for display
    } else {
        $result = selectStocks($pid, $conn);  // if no data is found in table then just display products details
        $row = $result->fetch_assoc();
    }
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <img style="height:450px" src="../image/product/<?php echo $row['p_image']; ?>" class="d-block w-100"
                        alt="Product Image">
                </div>
            </div>
            <div class="col-md-6">
                <h2>Name: <?php echo $row['p_name']; ?></h2>
                <p class="price"><strong>Price:</strong> Rs <?php echo $row['p_price']; ?></p>
                <p><strong>Model no:</strong> <?php echo $row['p_model']; ?></p>
                <p><strong>Brand:</strong> <?php echo $row['p_brand']; ?></p>
                <p><strong>Description:</strong> <?php echo $row['p_description']; ?></p>
            </div>
        </div>
    </div>
    <hr>

<?php } ?>

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

<!-- Form for ALL DETAIL -->
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
            </tr>
    </thead>
    <tbody>
        <?php
        //  if (isset($_GET['pid_stock_buy_btn']) || isset($_GET['pid_stock_SELL_btn']) || isset($_GET['pid_product_page'])) {
        //     $result = isset($_GET['pid_stock_buy_btn']) ? selectStocksBUY($pid, $conn) : (isset($_GET['pid_stock_SELL_btn']) ? 
        // selectStocksSELL($pid, $conn) : selectStocks($pid, $conn));
        


        // Display stock details if applicable
        if (isset($_GET['pid_stock_buy_btn'])) { //when buy btn is clicked
            $result = selectStocksBUY($pid, $conn);
        } elseif (isset($_GET['pid_stock_SELL_btn'])) { //when buy sell is clicked
            $result = selectStocksSELL($pid, $conn);
        } elseif (isset($_GET['pid_product_page'])) { // pid comes from product page ko View AND when aall button is clicked
            $result = selectStocks($pid, $conn);
        }
        if ($result && $result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                // ternery consiton statement
                $inOutText = ($row['s_in_out'] == 0) ?
                    '<p style="color:red;font-size:20px;"><strong>BUY</strong></p>' :
                    '<p style="color:green;font-size:20px;"><strong>SELL</strong></p>';

                echo '
                    <tr>
                        <th scope="row">' . $i++ . '</th>
                        <td>' . $row['s_quantity'] . '</td>
                        <td>' . $inOutText . '</td>
                        <td>' . $row['s_entryDate'] . '</td>
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