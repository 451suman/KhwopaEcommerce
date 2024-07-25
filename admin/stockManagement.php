<?php include "./layout/header.php";
include "./layout/admin_session.php";

?>

<?php
if (isset($_POST['Insert_submit_stock'])) {
    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $quantity = $_POST['quantity'];


    // Insert into stocks
    $sqlInsertStock = "INSERT INTO stocks (sid, pid, s_quantity, s_in_out, s_entryDate, s_productPrice)
                        VALUES (NULL, '$pid', '$quantity', '0', current_timestamp(), '$p_price')";

    // Update products
    $sqlUpdateProduct = "UPDATE products SET p_stocksQuantity = p_stocksQuantity + $quantity WHERE pid = $pid";

    // Execute queries
    if ($conn->query($sqlInsertStock) && $conn->query($sqlUpdateProduct)) {
        $icon = "success";
        $msg = "Insert Stock Of " . htmlspecialchars($p_name) . " Successful";
        $loc = "product.php";
        msg_loc($icon, $msg, $loc);
    } else {
        $icon = "error";
        $msg = "Insert Stock Failed Of " . htmlspecialchars($p_name);
        $loc = "product.php";
        msg_loc($icon, $msg, $loc);
    }
}
?>



<?php
if (isset($_POST['insert_stocks_btn'])) {
    $pid = $_POST["pid"];
   
      $sql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand,
    products.p_description, products.p_price, products.p_dateAndTime, products.p_image,
    categorys.c_name
    FROM products
    INNER JOIN categorys ON products.cid = categorys.cid
    WHERE products.pid = $pid
    ORDER BY p_dateAndTime DESC ";
    if ($result = $conn->query($sql)) {
        $row = $result->fetch_assoc();
    }
}

?>

<div class="container text-center">
    <div class="row align-items-start">
        <div class="col">
            <p class="alert-primary edit_headings" style="color:white; font-size:20px;"><strong>Image</strong></p>
            <img id="productImage" src="../image/product/<?php echo $row['p_image']; ?>" alt="Product Image"
                class="img-fluid">
        </div>
        <div class="col">
            <form method="post" action="stockManagement.php">

                <p class="alert-primary edit_headings" style="color:white; font-size:20px;"><strong>Insert Product Stock
                        Quantity</strong></p>
                <p style="font-size:20px;"><strong>Product Name : </strong><?php echo $row['p_name']; ?></p>
                <p style="font-size:20px;"><strong>Category Name : </strong><?php echo $row['c_name']; ?></p>
                <p style="font-size:20px;"><strong>Model no : </strong><?php echo $row['p_model']; ?></p>
                <p style="font-size:20px;"><strong>Brand : </strong><?php echo $row['p_brand']; ?></p>
                <p style="font-size:20px;"><strong>Price : </strong><?php echo $row['p_price']; ?></p>
                <p style="font-size:20px;"><strong>Description : </strong><?php echo $row['p_description']; ?></p>
                <div>
                    <label for="" class="form-label mt-4"><strong>Enter a Stock Quantity</strong></label>
                    <input type="number" name="quantity" class="form-control" min="0" id="uqntity">
                </div>

                <br>
                <input type="hidden" name="pid" value="<?php echo $pid; ?>" id="">
                <input type="hidden" name="p_name" value="<?php echo $row['p_name']; ?>" id="">
                <input type="hidden" name="p_price" value="<?php echo $row['p_price']; ?>" id="">
                <button type='submit' name='Insert_submit_stock' class='btn btn-primary'>Insert</button>



            </form>
        </div>

    </div>
</div>



<?php include "./layout/footer.php" ?>