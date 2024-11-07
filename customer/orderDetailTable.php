<?php
include "./layout/header.php";
include "./layout/customer_session.php";
?>

<?php
if (isset($_GET['cancell_order'])) {
    $oid = $_GET['oid'];
    $cancell_order_sql = "UPDATE orders SET o_orderStatus = 'cancelled' WHERE oid = $oid";
    $result = $conn->query($cancell_order_sql);
    if ($result) {
        msg_loc("error", "Order cancelled", "orderDetailTable.php");
    }
}
?>


<!-- Table displaying order details -->
<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">SN</th>
            <th scope="col">Product Name</th>
            <th scope="col">Shipping Address</th>
            <th scope="col">Total Quantity</th>
            <th scope="col">Order Status</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT orders.oid, orders.uid, orders.pid, orders.o_shippingAddress, 
                       orders.o_quantity, orders.o_orderStatus, orders.o_totalAmount, 
                       orders.o_date, products.pid, products.p_name
                FROM orders
                INNER JOIN products ON products.pid = orders.pid
                WHERE orders.uid = $uid
                ORDER BY orders.o_date DESC";

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                // Determine the status and message display
                $pending_complete = '';
                $pending_complete_msg = '';

                if ($row['o_orderStatus'] == "pending") {
                    $pending_complete = '<p style="font-size:20px;" class="text-warning"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                    $pending_complete_msg = '<p style="font-size:10px;" class="text-warning">
                    Youu have 24 Hours to cancelled your Products.<br> Waiting for conform your order</p>';
                } elseif ($row['o_orderStatus'] == "cancelled") {
                    $pending_complete = '<p style="font-size:20px;" class="text-danger"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                } elseif ($row['o_orderStatus'] == "completed") {
                    $pending_complete = '<p style="font-size:20px;" class="text-success"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                    $pending_complete_msg = '<p style="font-size:10px;" class="text-success">Thank you for your purchase.</p>';
                } elseif ($row['o_orderStatus'] == "conformed") {
                    $pending_complete = '<p style="font-size:20px;" class="text-primary"><strong>' . $row['o_orderStatus'] . '</strong></p>';
                    $pending_complete_msg = '<p style="font-size:10px;" class="text-primary">Thank you for your purchase.</p>';

                }

                echo '
                    <tr>
                        <th scope="row">' . $i++ . '</th>
                        <td>' . $row['p_name'] . '</td>
                        <td>' . $row['o_shippingAddress'] . '</td>
                        <td>' . $row['o_quantity'] . '</td>
                        <td>' . $pending_complete . $pending_complete_msg . '</td>
                        <td>' . $row['o_totalAmount'] . '</td>
                        <td>' . $row['o_date'] . '</td>';

                // Action buttons
                if ($row['o_orderStatus'] == "pending") {
                    echo '
                    <td>
                        <p class="text-warning">review botton will be available when order is completed</p>
                    </td>';
                } elseif ($row['o_orderStatus'] == "completed") {
                    echo '
                        <td>
                               <a href="product_single.php?pid=' . $row['pid'] . '" class="btn btn-primary">Give Review</a>
                        </td>';
                    // this a herf tag will Tale u to product_single. php page with id in ti to display that id Product in that page
        
                } else {
                    echo '
                    <td>
                        <p class="text-warning">review botton will be available when order is completed</p>
                    </td>';
                }
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="8">No order details found.</td></tr>';
        }
        ?>
    </tbody>
</table>

<?php include "./layout/footer.php"; ?>