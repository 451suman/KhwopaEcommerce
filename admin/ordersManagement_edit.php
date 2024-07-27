<?php include "./layout/header.php";
include "./layout/admin_session.php";
?>

<?php


if(isset($_GET['update_orderStatus_btn'])){
$oid =$_GET['oid'];
$orderstatus =$_GET['orderstatus'];
echo $orderstatus."  ". $oid;
die();
$sqlupdate_orderStatus="UPDATE orders SET o_orderStatus = '$orderstatus' WHERE oid = $oid";
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

            <p class="text-primary"><strong>User Name:</strong>
                <?php echo $row['first_name'] . " " . $row['last_name']; ?> </p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?> </p>
            <p><strong>phone:</strong> <?php echo $row['phone']; ?> </p>
            <p><strong>Product Name:</strong> <?php echo $row['p_name']; ?> </p>
            <p><strong>o_shippingAddress:</strong> <?php echo $row['o_shippingAddress']; ?> </p>
            <p><strong>o_quantity:</strong> <?php echo $row['o_quantity']; ?> </p>
            <p><strong> Order Status:</strong> <?php echo $row['o_orderStatus']; ?> </p>
            <p><strong>Shipping Address:</strong> <?php echo $row['o_shippingAddress']; ?> </p>
            <p><strong>total amount=</strong> Rs <?php echo $row['o_totalAmount']; ?></p>
            <p><strong>Date=</strong> Rs <?php echo $row['o_date']; ?></p>
            <p><strong>Model no </strong>: <?php echo $row['p_model']; ?></p>
            <p><strong>Left in Stocks</strong> : <?php echo $row['p_stocksQuantity']; ?></p>
            <p><strong>Description</strong> : <?php echo $row['p_description']; ?></p>

            <div class="options">
            </div>
            <hr>
            <form action="ordersManagement_edit.php" method="get">
                <div>
                   <h2> <label for="exampleSelect1" class="form-label mt-4">Order Status</label></h2>
                    <select class="form-select bg-light " name="orderstatus"id="exampleSelect1">
                        <option value="pending" class=" bg-danger">Order Pending</option>
                        <option value="conform"class=" bg-warning">Order Conform</option>
                        <option value="completed"class=" bg-success">Order Completed</option>
                    </select>
                </div>
                <p id="totalprice" class="text-danger" style="font-size: 30px;"></p>
                <input type="hidden" name="oid" value="<?php echo $row['oid']; ?>">
                <button type="submit" class="btn btn-primary" name="update_orderStatus_btn">update</button>
        </div>
        </form>


        <div class="row mt-5">
        </div>
    </div>
</div>
</div>
<hr>

<div style="margin-left:20%;margin-right:20%;">
    <p class="alert-primary edit_headings" style="color:white; margin-top:20px;padding:10px; font-size:30px;">EDIT ORDER
        STATUS</p>
    <form action="">
        <div>
            <label for="exampleSelect1" class="form-label mt-4">Example select</label>
            <select class="form-select" id="exampleSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </form>
</div>

<?php include "./layout/footer.php" ?>