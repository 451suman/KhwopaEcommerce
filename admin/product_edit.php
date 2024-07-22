<?php
include "./layout/header.php";
include "./layout/admin_session.php";
include "../database/db.php";
?>





<?php
// data collected from product.php page 
if (isset($_POST['edit_product_btn'])) {
    $pid = $_POST['pid'];
    $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_color, products.p_brand, products.p_description, products.p_price, products.p_stockQuantity, products.p_imageURL, categorys.c_name FROM products INNER JOIN categorys ON products.cid = categorys.cid WHERE pid = $pid";
    $result = $conn->query($Selectsql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>


        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <!-- Display product image -->
                    <img id="productImage" src="<?php echo $product['p_imageURL']; ?>" alt="Product Image" class="img-fluid">
                </div>
                <div class="col">
                    <form method="post" action="product_edit.php">
                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">

                        <div class="mb-3">
                            <label for="ProductName" class="form-label">Product Name</label>
                            <input type="text" name="p_name" class="form-control" id="ProductName"
                                value="<?php echo $product['p_name']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ProductCategory" class="form-label">Category</label>
                        </div>

                        <div class="container">
                            <div class="row">
                                <?php
                                $sql = "SELECT * FROM categorys ORDER BY c_name ASC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="optionsRadios' . $row['cid'] . '" value="' . $row['cid'] . '" ' . ($row['cid'] == $product['cid'] ? 'checked' : '') . '>
                                    <label class="form-check-label" for="optionsRadios' . $row['cid'] . '">
                                        ' . $row['c_name'] . '
                                    </label>
                                </div>
                            </div>
                        ';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="Color" class="form-label">Color</label>
                            <input type="text" name="color" class="form-control" id="Color"
                                value="<?php echo $product['p_color']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="Brand" class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control" id="Brand"
                                value="<?php echo $product['p_brand']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" id="Description"
                                value="<?php echo $product['p_description']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price"
                                value="<?php echo $product['p_price']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="Stock" class="form-label">Stock Quantity</label>
                            <input type="number" name="Stock" class="form-control" id="Stock"
                                value="<?php echo $product['p_stockQuantity']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ProductImageurl" class="form-label">Image URL Address</label>
                            <input type="url" name="url" class="form-control" id="ProductImageurl"
                                placeholder="Paste Image Address Here" value="<?php echo $product['p_imageURL']; ?>" required>
                        </div>

                        <button type="submit" name="edit_product_submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>





    <?php
    } else {
        echo '<p>No product found with the provided ID.</p>';
    }
} ?>


<?php

if (isset($_POST['edit_product_submit'])) {
    // Retrieve form data
    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $category = $_POST['category'];
    $color = $_POST['color'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['Stock'];
    $imageURL = $_POST['url'];

    // Prepare the SQL statement
    $updateSql = "UPDATE products 
                  SET p_name = ?, cid = ?, p_color = ?, p_brand = ?, p_description = ?, p_price = ?, p_stockQuantity = ?, p_imageURL = ? 
                  WHERE pid = ?";

    // Initialize a prepared statement
    $stmt = $conn->prepare($updateSql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('sissssssi', $p_name, $category, $color, $brand, $description, $price, $stock, $imageURL, $pid);

        // Execute the statement
        if ($stmt->execute()) {
            echo '<script >';
            echo 'swal.fire({
                     icon: "success",
                    title: "Wow!",
                    text: "Update Sucessful",
                   
                }).then(function() {
                    window.location = "product.php";
                });';
            echo '</script>';
        } else {
            echo '<script >';
            echo 'swal.fire({
                     icon: "error",
                    title: "Wow!",
                    text: "Update Failed",
                   
                }).then(function() {
                    window.location = "product.php";
                });';
            echo '</script>';

        }

        // Close the statement
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger" role="alert">Error preparing the statement: ' . $conn->error . '</div>';
    }

    // Close the connection
    $conn->close();
}
?>


<script>
    document.getElementById('ProductImageurl').addEventListener('input', function () {
        var imageUrl = this.value;
        document.getElementById('productImage').src = imageUrl;
    });
</script>

<?php
include "./layout/footer.php";
?>