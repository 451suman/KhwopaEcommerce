<?php include "./layout/header.php";
include "./layout/admin_session.php";
?>

<?php
$sql = "SELECT orders.oid, orders.uid, orders.pid, orders.o_shippingAddress, 
       orders.o_quantity, orders.o_orderStatus, orders.o_totalAmount, 
       orders.o_date, products.pid, products.p_name,products.p_image,products.p_model,products.p_stocksQuantity,
       users.uid,users.first_name, users.last_name,users.email,users.phone
       FROM orders
       INNER JOIN products ON products.pid = orders.pid
       INNER JOIN users ON users.uid = orders.uid
       ORDER BY orders.o_date DESC
       ";
$result = $conn->query($sql);
?>
<!-- 
<form action="" method = "get">
<i class="bi bi-filter">Filter</i>
    <select class="form-select" value="<?php  ?>" name="orderstatus"
        id="exampleSelect1">
        <option value="all" class=" text-warning">All Order</option>
        <option value="pending" class=" text-warning">Order Pending</option>
        <option value="conformed" class=" text-primary" >Order Conformed</option>
        <option value="completed" class=" text-success">Order Completed</option>
        <option value="cancelled" class=" text-danger">Order Completed</option>
    </select>
    <button type="submit" name="filter_btn" class="btn btn-info form_btn_stock">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
  <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
</svg> Filter
</button>

</form> -->



<!-- <form action="" method="get">
    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    
    <button type="submit" name="pid_stock_buy_btn" class="btn btn-warning form_btn_stock">PENDINNG</button>
    </form> -->

    <!-- Form for SELL DETAIL -->
    <!-- <form action="" method="get">
        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
        <button type="submit" name="pid_stock_SELL_btn" class="btn btn-success form_btn_stock">Complete</button>
    </form> -->

    <!-- Form for ALL DETAIL -->
    <!-- <form action="" method="get">
        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
        <button type="submit" name="pid_product_page" class="btn btn-danger form_btn_stock">Cancelled</button>
    </form> -->

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">SN</th>
            <th scope="col">User Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Product Name</th>
            <th scope="col">Product model no</th>
            <th scope="col">Shipping Adddress</th>
            <th scope="col">Left Stock</th>
            <th scope="col"> Total Quantity Ordered</th>
            <th scope="col"> Order Status</th>
            <th scope="col"> Total Amount</th>
            <th scope="col"> Date </th>
            <th scope="col"> Image </th>
            <th scope="col"> Action </th>
        </tr>
    </thead>
    <tbody></tbody>
    <?php
    if ($result && $result->num_rows > 0) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            // if o_orderstatus == pendinng then display pending with red color else displau complete with green color 
            $pending_complete = '';
            if ($row['o_orderStatus'] == "pending") {
                $pending_complete = '<p style="font-size:20px;" class="text-warning"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            } elseif ($row['o_orderStatus'] == "cancelled") {
                $pending_complete = '<p style="font-size:20px;" class="text-danger"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            } elseif ($row['o_orderStatus'] == "completed") {
                $pending_complete = '<p style="font-size:20px;" class="text-success"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            } elseif ($row['o_orderStatus'] == "conformed") {
                $pending_complete = '<p style="font-size:20px;" class="text-primary"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            }
            echo '
                    <tr>
                        <th scope="row">' . $i++ . '</th>
                        <td>' . $row['first_name'] . " " . $row['last_name'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td>' . $row['phone'] . '</td>
                        <td>' . $row['p_name'] . '</td>
                        <td>' . $row['p_model'] . '</td>
                        <td>' . $row['o_shippingAddress'] . '</td>
                        <td>' . $row['p_stocksQuantity'] . '</td>
                        <td>' . $row['o_quantity'] . '</td>
                        <td>' . $pending_complete . '</td>
                        <td>' . $row['o_totalAmount'] . '</td>
                        <td>' . $row['o_date'] . '</td>
                         <td><img class="Product_table_image" src="../image/product/' . $row['p_image'] . '"></td>
                        <td> ';
            if ($row['o_orderStatus'] != "completed" && $row['o_orderStatus'] != "cancelled") { //if order status is not completed then only display button
                echo '
                        <form action="ordersManagement_edit.php" method="get">
                            
                            <input type="hidden" name="oid" value="' . $row['oid'] . '" id="">
                            <input type="submit" value="edit order status" name="order_Edit_btn" class="btn btn-primary" id="">
                        </form>
                        </td>
                    </tr>
                    ';
            }
        }
    } else {
        echo '<tr><td colspan="5">No stock details found.</td></tr>';
    }
    ?>
    </tbody>
</table>
<?php include "./layout/footer.php" ?>