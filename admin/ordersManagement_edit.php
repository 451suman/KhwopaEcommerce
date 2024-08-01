<?php include "./layout/header.php";
include "./layout/admin_session.php";
?>

<?php


if (isset($_GET['update_orderStatus_btn'])) {
    $oid = $_GET['oid'];
    $pid = $_GET['pid'];
    $o_totalAmount = $_GET['o_totalAmount'];
    $o_quantity = $_GET['o_quantity'];//ordered quantity by customer
    $p_stocksQuantity = $_GET['p_stocksQuantity']; //product stock left
    $orderstatus = $_GET['orderstatus'];
    $left_product_quantity = $p_stocksQuantity - $o_quantity;

    // echo $orderstatus . "  " . $oid . "  " . $pid;
    // echo "<br>stock=" . $p_stocksQuantity . "    o_quantity=".$o_quantity."    sub=" . $left_product_quantity."<br> total amount =". $o_totalAmount;
    // die();
    $sqlupdate_orderStatus = "UPDATE orders SET o_orderStatus = '$orderstatus' WHERE oid = $oid";
    $sqlproduct = "UPDATE products SET p_stocksQuantity = '$left_product_quantity' WHERE pid = $pid";
    $sqlstock = "INSERT INTO stocks (pid, s_quantity, s_in_out,  s_productPrice) VALUES ('$pid', '$o_quantity', '1','$o_totalAmount')";

    if ($orderstatus == "completed") { // if order is completed then run this code
        // Update product stock quantity
        if ($conn->query($sqlproduct) && $conn->query($sqlupdate_orderStatus) && $conn->query($sqlstock)) {
            $icon = "success";
            $msg = "Order status of $oid is $orderstatus";
            $loc = "ordersManagement.php";
            msg_loc($icon, $msg, $loc);
        }
    } elseif ($conn->query($sqlupdate_orderStatus)) {
        $icon = "success";
        $msg = "Order status of $oid is $orderstatus"; //for pending and conformed ordered
        $loc = "ordersManagement.php";
        msg_loc($icon, $msg, $loc);
    } else {
        $icon = "error";
        $msg = "Failed to update order status for order";
        $loc = "ordersManagement.php";
        msg_loc($icon, $msg, $loc);
    }

}


if (isset($_GET['order_Edit_btn'])) {
    // $o_orderStatus = $_GET['o_orderStatus'];
    $oid = $_GET['oid'];

    $sql = "SELECT orders.oid, orders.uid, orders.pid, orders.o_shippingAddress, 
    orders.o_quantity, orders.o_orderStatus, orders.o_totalAmount, 
    orders.o_date, products.pid, products.p_name,products.p_image,products.p_model,products.p_description,products.p_stocksQuantity,
    users.uid,users.first_name, users.last_name,users.email,users.phone
    FROM orders
    INNER JOIN products ON products.pid = orders.pid
    INNER JOIN users ON users.uid = orders.uid
    WHERE oid = $oid    ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
       // if o_orderstatus == pendinng then display pending with red color else displau complete with green color 
            $pending_complete = '';
            if ($row['o_orderStatus'] == "pending") {
                $pending_complete = '<p style="font-size:20px;" class="text-warning"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            } elseif ($row['o_orderStatus'] == "conformed") {
                $pending_complete = '<p style="font-size:20px;" class="text-primary"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            } elseif ($row['o_orderStatus'] == "completed") {
                $pending_complete = '<p style="font-size:20px;" class="text-success"><strong>' . $row['o_orderStatus'] . '</strong></p>';
            }

}
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="">
                <img style="height:450px" src="../image/product/<?php echo $row['p_image']; ?>" class="d-block w-100"
                    alt="Sweatshirt Image 1">
            </div>
        </div>
        <div class="col-md-6">
            <p class="alert-primary edit_headings" style="color:white;font-size:20px;">EDIT ORDER
                STATUS</p>
            <p class="text-primary"><strong>User Name:</strong>
                <?php echo $row['first_name'] . " " . $row['last_name']; ?> </p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?> </p>
            <p><strong>phone:</strong> <?php echo $row['phone']; ?> </p>
            <p><strong>Product Name:</strong> <?php echo $row['p_name']; ?> </p>
            <p><strong>Date=</strong> Rs <?php echo $row['o_date']; ?></p>
            <p><strong>Model no </strong>: <?php echo $row['p_model']; ?></p>
            <p><strong>Left in Stocks</strong> : <?php echo $row['p_stocksQuantity']; ?></p>
            <p><strong>shipping Address:</strong> <?php echo $row['o_shippingAddress']; ?> </p>
            <p><strong>Total Ordered Quantity: </strong> <?php echo $row['o_quantity']; ?> </p>
            <p><strong>Description</strong> : <?php echo $row['p_description']; ?></p>
            <p><strong>total amount=</strong> Rs <?php echo $row['o_totalAmount']; ?></p>

            <div class="options">
            </div>
            <hr>
            <div style="background-color:#c2e2ef;"><strong> Order Status: <?php echo $pending_complete; ?></strong></div>
            <form action="ordersManagement_edit.php" method="get">
                <div>
                    <h2> <label for="exampleSelect1" class="form-label mt-4">Order Status</label></h2>
                    <select class="form-select " value="<?php echo $row['o_orderStatus']; ?>" name="orderstatus" id="exampleSelect1">
                        <option value="pending" class=" text-danger">Order Pending</option>
                        <option value="conformed" class=" text-warning">Order Conformed</option>
                        <option value="completed" class=" text-success">Order Completed</option>
                    </select>
                </div>
                <p id="totalprice" class="text-danger" style="font-size: 30px;"></p>
                <input type="hidden" name="oid" value="<?php echo $row['oid']; ?>">
                <input type="hidden" name="p_stocksQuantity" value="<?php echo $row['p_stocksQuantity']; ?>">
                <input type="hidden" name="o_quantity" value="<?php echo $row['o_quantity']; ?>">
                <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
                <input type="hidden" name="o_totalAmount" value="<?php echo $row['o_totalAmount']; ?>">
                <button type="submit" class="btn btn-primary" name="update_orderStatus_btn">update</button>
        </div>
        </form>


        <div class="row mt-5">
        </div>
    </div>
</div>
</div>
<hr>



<?php include "./layout/footer.php" ?>