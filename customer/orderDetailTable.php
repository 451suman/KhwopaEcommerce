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
                $pending_complete = '';
                if ($row['o_orderStatus'] == "pending") {
                    $pending_complete = '<p style="font-size:20px;" class="text-warning"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                } elseif ($row['o_orderStatus'] == "conformed") {
                    $pending_complete = '<p style="font-size:20px;" class="text-primary"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                } elseif ($row['o_orderStatus'] == "completed") {
                    $pending_complete = '<p style="font-size:20px;" class="text-success"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                }
                $pending_complete_msg = '';
                if ($row['o_orderStatus'] == "pending") {
                    $pending_complete_msg = '<p style="font-size:10px;" class="text-warning">Wating to conform yout order</p>';
                } elseif ($row['o_orderStatus'] == "conformed") {
                    $pending_complete_msg = '<p style="font-size:10px;" class="text-primary">YOur product has been conformed. Delivery will be in 1 week.</p>';
                } elseif ($row['o_orderStatus'] == "completed") {
                    $pending_complete_msg = '<p style="font-size:10px;" class="text-success">Thank you for purchasing.</p>';
                }

                echo '
                    <tr>
                        <th scope="row">' . $i++ . '</th>
                        <td>' . $row['p_name'] . '</td>
                        <td>' . $row['o_shippingAddress'] . '</td>
                        <td>' . $row['o_quantity'] . '</td>
                        <td>' .$pending_complete. ' '.$pending_complete_msg.'</td>
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