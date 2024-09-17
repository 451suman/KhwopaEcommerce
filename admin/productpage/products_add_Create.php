    <!-- Add Product Button -->
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" method="post" action="product.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="ProductName" class="form-label">Product Name</label>
                            <input type="text" name="p_name" class="form-control" id="ProductName" required>
                        </div>
                        <div class="mb-3">
                            <label for="ProductName" class="form-label">Category</label>
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
                                                    <input class="form-check-input" type="radio" name="category" id="optionsRadios' . $row['cid'] . '" value="' . $row['cid'] . '">
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
                            <input type="text" name="model" class="form-control" id="Color" required>
                        </div>

                        <div class="mb-3">
                            <label for="Brand" class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control" id="Brand" required>
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="Description" rows="3" placeholder="describe about products, like size,color etc"
                                required></textarea>
                            <!-- <input type="text" name="description" class="form-control" id="Description"  required> -->
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="ProductImageurl" class="form-label">Upload Image</label>
                            <input type="file" name="image_file" class="form-control" id="ProductImageurl"
                                accept=".jpg,.png,.jpeg" required>

                        </div>

                        <button type="submit" name="Product_submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Product Modal ends -->