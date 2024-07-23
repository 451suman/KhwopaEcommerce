<?php 
include "./layout/header.php";
include "./layout/admin_session.php";
include "../database/db.php";
?>





<?php
// data collected from product.php page 
if(isset($_POST['edit_product_btn'])) {
    $pid = $_POST['pid'];
    $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, products.p_description, products.p_price, products.p_stockQuantity, products.p_imageURL, categorys.c_name FROM products INNER JOIN categorys ON products.cid = categorys.cid WHERE pid = $pid";
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
        
      <form method="post" action="product.php">
        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">

        <div class="mb-3">
            <label for="ProductName" class="form-label">Product Name</label>
            <input type="text" name="p_name" class="form-control" id="ProductName" value="<?php echo $product['p_name']; ?>" required>
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
            <label for="Color" class="form-label">Model No</label>
            <input type="text" name="model" class="form-control" id="Color" value="<?php echo $product['p_model']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Brand" class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" id="Brand" value="<?php echo $product['p_brand']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" name="description" class="form-control" id="Description" maxlength="100" value="<?php echo $product['p_description']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" class="form-control" id="price" value="<?php echo $product['p_price']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Stock" class="form-label">Stock Quantity</label>
            <input type="number" name="Stock" class="form-control" id="Stock" value="<?php echo $product['p_stockQuantity']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="ProductImageurl" class="form-label">Image URL Address</label>
            <input type="url" name="url" class="form-control" id="ProductImageurl" placeholder="Paste Image Address Here" value="<?php echo $product['p_imageURL']; ?>" required>
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
}?>





<script>
document.getElementById('ProductImageurl').addEventListener('input', function() {
    var imageUrl = this.value;
    document.getElementById('productImage').src = imageUrl;
});
</script>

<?php
include "./layout/footer.php";
?>

