<?php
include "./layout/header.php";
include "./layout/customer_session.php";
?>
<form action="" method="get">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <button type="submit" name="pid_stock_buy_btn" class="btn btn-warning form_btn_stock">PENDINNG</button>
</form>

<!-- Form for colplete order DETAIL -->
<form action="" method="get">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <button type="submit" name="pid_stock_SELL_btn" class="btn btn-success form_btn_stock">Complete</button>
</form>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">SN</th>
            <th scope="col">Product Name</th>
            <th scope="col">Shipping Adddress</th>
            <th scope="col"> Total Quantity</th>
            <th scope="col"> Order Status</th>
            <th scope="col"> Total Amount</th>
            <th scope="col"> Date </th>
            <!-- <th scope="col"> Action </th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT orders.oid, orders.uid, orders.pid, orders.o_shippingAddress, 
       orders.o_quantity, orders.o_orderStatus, orders.o_totalAmount, 
       orders.o_date, products.pid, products.p_name
       FROM orders
       INNER JOIN products ON products.pid = orders.pid
       WHERE orders.uid = $uid";

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {

                // if o_orderstatus == pendinng then display pending with red color else displau complete with green color 
                $pending_complete = ($row['o_orderStatus'] == "pending") ?
                    '<p style="color:red;font-size:20px;"><strong>' . $row['o_orderStatus'] . '</strong></p>' :
                    '<p style="color:green;font-size:20px;">' . $row['o_orderStatus'] . '</strong></p>';
                echo '
                    <tr>
                        <th scope="row">' . $i++ . '</th>
                        <td>' . $row['p_name'] . '</td>
                        <td>' . $row['o_shippingAddress'] . '</td>
                        <td>' . $row['o_quantity'] . '</td>
                        <td>' .$pending_complete. '</td>
                        <td>' . $row['o_totalAmount'] . '</td>
                        <td>' . $row['o_date'] . '</td>
                        
                       
                    </tr>
                    ';
            }
        } else {
            echo '<tr><td colspan="5">No stock details found.</td></tr>';
        }

        ?>
    </tbody>
</table>




<?php include "./layout/footer.php" ?>