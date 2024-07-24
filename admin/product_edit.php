<?php
include "./layout/header.php";
include "./layout/admin_session.php";
include "../database/db.php";
?>

<?php
// Handle the data collected from the edit page
if (isset($_POST['edit_product_btn'])) {
    $pid = $_POST['pid'];
    $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand,
     products.p_description, products.p_price, products.p_image, categorys.c_name
     FROM products 
     INNER JOIN categorys ON products.cid = categorys.cid 
     WHERE pid = $pid";
    $result = $conn->query($Selectsql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>

        <div class="container text-center">
            <div class="row align-items-start">
                <div class="col">
                    <!-- Display product image -->
                    <p style="background-color:black; color:white; font-size:20px;"> Current Using Image</p>
                    <img id="productImage" src="../image/product/<?php echo $product['p_image']; ?>" alt="Product Image"
                        class="img-fluid">
                </div>
                <div class="col">
                    <p style="background-color:black; color:white; font-size:20px;"> Edit Product Details</p>
                    <form method="post" action="product.php" enctype="multipart/form-data">
                      

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
                                    ' . htmlspecialchars($row['c_name']) . '
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
                            <label for="Color" class="form-label">Model No</label>
                            <input type="text" name="model" class="form-control" id="Color"
                                value="<?php echo htmlspecialchars($product['p_model']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="Brand" class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control" id="Brand"
                                value="<?php echo htmlspecialchars($product['p_brand']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="Description" rows="3"
                                required><?php echo htmlspecialchars($product['p_description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price"
                                value="<?php echo htmlspecialchars($product['p_price']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ProductImageurl" class="form-label">Upload New Image (Optional)</label>
                            <input type="file" name="image_file" class="form-control" id="ProductImageurl"
                                accept=".jpg,.png,.jpeg">
                        </div>
                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                        <input type="hidden" name="old_image" value="<?php echo $product['p_image']; ?>">
                        <button type="submit" name="edit_product_submit" class="btn btn-primary">Update Product</button>
                    </form>


                </div>
            </div>
        </div>

        <?php
    } else {
        echo '<p>No product found with the provided ID.</p>';
    }
}
?>


<?php
include "./layout/footer.php";
?>

