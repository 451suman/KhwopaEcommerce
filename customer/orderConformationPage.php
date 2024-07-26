<?php
include "./layout/header.php";
include "./layout/customer_session.php";

// Ensure $uid is set and valid
if (!isset($_SESSION["users"])) {
    header("Location: ../welcomepage/home.php");
    exit();
}

$uid = $_SESSION["users"];

if (isset($_GET['conform_order_btn'])) {
    $shipping_address = $_GET['shipping_address'];
    $quantity = $_GET['quantity'];
    $pid = $_GET['pid'];

    // Debug output (remove or comment out in production)
    echo htmlspecialchars("$shipping_address <br> $quantity <br>$pid");
    die();
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
                <img style="height:450px" src="../image/product/<?php echo htmlspecialchars($row['p_image']); ?>"
                    class="d-block w-100" alt="Product Image">
            </div>
        </div>
        <div class="col-md-6">
            <h2>Name: <?php echo htmlspecialchars($row['p_name']); ?></h2>
            <p class="price"><strong>Price:</strong> Rs <?php echo htmlspecialchars($row['p_price']); ?></p>
            <p><strong>Model No:</strong> <?php echo htmlspecialchars($row['p_model']); ?></p>
            <p><strong>Brand:</strong> <?php echo htmlspecialchars($row['p_brand']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($row['p_description']); ?></p>
            <hr>
            <p class="alert-primary edit_headings" style="color:white; font-size:20px;">
                <strong>Confirm Order Form</strong>
            </p>
            <form action="orderConformationPage.php" method="get">
                <div class="mb-3">
                    <label for="shipping_address" class="form-label">Shipping Address</label>
                    <input type="text" name="shipping_address" class="form-control" id="shipping_address"
                        value="<?php echo htmlspecialchars($user['district'] . ', ' . $user['city']); ?>" required>
                    <p class="text-warning">If this address is not where you want to ship, please change the address.
                    </p>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" name="quantity" class="form-control bg-light" id="quantity"
                        value="<?php echo htmlspecialchars($quantity); ?>" readonly>
                </div>

                <input type="hidden" name="pid" value="<?php echo htmlspecialchars($row['pid']); ?>">
                <input type="submit" value="Confirm Your Order" name="conform_order_btn" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<hr>

<?php include "./layout/footer.php"; ?>