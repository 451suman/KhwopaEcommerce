<?php
include "./layout/header.php";
include "./layout/customer_session.php";



if (isset($_GET['conform_order_btn'])) {
    $shipping_address = $_GET['shipping_address'];
    $quantity = $_GET['quantity'];
    $pid = $_GET['pid'];
    $p_price = $_GET['p_price'];
    $total_price = $_GET['total_price'];

    $p_stocksQuantity = $_GET['p_stocksQuantity'];
    $leftStockQuantity = $p_stocksQuantity - $quantity;  //update stocks in product table

        $order_insert = "INSERT INTO orders (uid, pid, o_totalAmount, o_shippingAddress, o_orderStatus, o_quantity, o_date)
     VALUES (' $uid', ' $pid', '$total_price', ' $shipping_address', 'pending', '$quantity', current_timestamp())";

       

       
        $orderRes = $conn->query($order_insert);
       
        if ($orderRes) {
            $icon = "success";
            $msg = "Order confirmed.Delivery will be in 2 - 3 days.";
            $loc = "orderDetailTable.php";
            msg_loc($icon, $msg, $loc);
        } else {
            $icon = "success";
            $msg = "Order failed.";
            $loc = "products.php";
            msg_loc($icon, $msg, $loc);
        }



    // echo"<br><br> aaba sql query lekha <br><br>
    //     to inser data in  order table and <br><br>
    //     multiply price * total quntity<br><br>
    //      the subract total quantity in product table quntity<br><br>
    // ";
    // die();
}

if (isset($_GET['BUT_IT'])) {
    $pid = $_GET['pid'];
    $quantity = $_GET['Quantity']; // Ensure correct case sensitivity

    // Fetch user data
    $user_sql = "SELECT * FROM users WHERE uid = $uid";
    $Selectsql = "SELECT * FROM products WHERE pid = $pid"; // Fixed typo: 'pro45ducts' to 'products'

    try {
        // Execute queries
        $result1 = $conn->query($user_sql);
        $result2 = $conn->query($Selectsql);

        // Check if results contain rows
        if ($result1->num_rows > 0 && $result2->num_rows > 0) {
            $user = $result1->fetch_assoc();
            $row = $result2->fetch_assoc();
        } else {
            $icon = 'error';
            $msg = "User or product not found. Returning to Home page.";
            $loc = "home.php";
            msg_loc($icon, $msg, $loc);

        }
    } catch (Exception $e) {
        // Handle exceptions
        $icon = 'error';
        $msg = "An error occurred: " . $e->getMessage() . "<br> Returning to Home page.";
        $loc = "home.php";
        msg_loc($icon, $msg, $loc);
    }
}

?>

<p class="alert-primary edit_headings" style="color:white; font-size:20px; margin-left:10%; margin-right:10%;">
    <strong>Confirm Your Order</strong>
</p>
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
            <p><strong>Model No:</strong> <?php echo $row['p_model']; ?></p>
            <p><strong>Brand:</strong> <?php echo $row['p_brand']; ?></p>
            <p><strong>Description:</strong> <?php echo $row['p_description']; ?></p>
            <hr>
            <p class="alert-primary edit_headings" style="color:white; font-size:20px;">
                <strong>Confirm Order Form</strong>
            </p>

            <?php $total_price = $row['p_price'] * $quantity; ?>
            <form action="orderConformationPage.php" method="get">
                <div class="mb-3">
                    <label for="shipping_address" class="form-label">Shipping Address</label>
                    <input type="text" name="shipping_address" class="form-control" id="shipping_address"
                        value="<?php echo $user['district'] . ', ' . $user['city']; ?>" required>
                    <p class="text-warning">If this address is not where you want to ship, please change the
                        address.<br>
                        Example: Bhaktapur,kamablinyak

                    </p>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" name="quantity" class="form-control bg-light" id="quantity"
                        value="<?php echo $quantity; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="total_price" class="form-label">Total Price</label>
                    <input type="text" name="total_price" class="form-control bg-light" id="quantity"
                        value="<?php echo $total_price; ?>" readonly>
                </div>


                <input type="hidden" name="p_stocksQuantity" value=" <?php echo $row['p_stocksQuantity']; ?>">
                <input type="hidden" name="p_price" value=" <?php echo $row['p_price']; ?>">
                <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
                <input type="submit" value="Confirm Your Order" name="conform_order_btn" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<hr>

<?php include "./layout/footer.php"; ?>