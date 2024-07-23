<?php include "./layout/header.php";
include "./layout/admin_session.php";
include "../database/db.php";
?>


<div class="container mt-4">
    <h2>Product Management</h2>


    <?php
            // EDIT PRODUCT back end
    if (isset($_POST['edit_product_submit'])) {
        // Retrieve form data
        $pid = $_POST['pid'];
        $p_name = $_POST['p_name'];
        $category = $_POST['category'];
        $model = $_POST['model'];
        $brand = $_POST['brand'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['Stock'];
        $imageURL = $_POST['url'];

        // Prepare the SQL statement
        $updateSql = "UPDATE products 
                  SET p_name = ?, cid = ?, p_model = ?, p_brand = ?, p_description = ?, p_price = ?, p_stockQuantity = ?, p_imageURL = ? 
                  WHERE pid = ?";

        // Initialize a prepared statement
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param('sissssssi', $p_name, $category, $model, $brand, $description, $price, $stock, $imageURL, $pid);

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

    <?php
    // add prduct
    if (isset($_POST["Product_submit"])) {
        $category = $_POST["category"];
        $p_name = $_POST["p_name"];
        $model = $_POST["model"];
        $brand = $_POST["brand"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $stock = $_POST["Stock"];
        $url = $_POST["url"];
        ;


        $Insertsql = "INSERT INTO products (cid, p_name, p_model, p_brand, p_description, p_price, p_stockQuantity, p_imageURL)
                             VALUES ('$category', '$p_name ', '$model', '$brand', '$description', '$price', '$stock', '$url')";
        $result = $conn->query($Insertsql);
        if ($result) {
            echo '<script>';
            echo "Swal.fire({
                    icon: 'success',
                    text: 'Category added into Database Successfully.',
                })";
            echo '</script>';
        } else {
            echo '<script>';
            echo "Swal.fire({
                            icon: 'error',
                            text: 'Failed to add Category into Database.',
                        })";
            echo '</script>';
        }

    }
    // end add product
    
    // delete product
    if (isset($_POST['delete_product'])) {
        $pid = $_POST["pid"];
        $deleteSql = "DELETE FROM products WHERE pid = $pid";
        $result = $conn->query($deleteSql);
        if ($result) {
            echo '<script>';
            echo "Swal.fire({
                        icon: 'success',
                        text: 'Delete products form Database Successfully.',
                    })";
            echo '</script>';
        } else {
            echo '<script>';
            echo "Swal.fire({
                        icon: 'error',
                        text: 'Delete products form Database Failed.',
                    })";
            echo '</script>';
        }
    }
    // delete product end
    
    ?>
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
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" method="post" action="product.php">
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
                            <input type="text" name="description" class="form-control" id="Description" maxlength="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="Stock" class="form-label">Stock Quantity</label>
                            <input type="number" name="Stock" class="form-control" id="Stock" required>
                        </div>


                        <div class="mb-3">
                            <label for="ProductImageurl" class="form-label">Image URL Address</label>
                            <input type="url" name="url" class="form-control" id="ProductImageurl"
                                placeholder="Paste Image Address Here" value="" required>
                        </div>
                        <div class="col">
                            <!-- Display product image -->
                            <img id="productImage" style="height: 200px;" src="" alt="Product Image" class="img-fluid">
                        </div>

                        <button type="submit" name="Product_submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Product Modal ends -->

    <!-- Product Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">SN</th>
                <th width="10%">Name</th>
                <th width="10%">Category</th>
                <th width="10%">Model No</th>
                <th width="10%">Brand</th>
                <th width="20%">Description</th>
                <th width="5%">Stock</th>
                <th width="10%">Price</th>
                <th width="10%">Image</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryTable">
            <?php

            $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, products.p_description, products.p_price, products.p_stockQuantity, products.p_imageURL,
           categorys.c_name
           FROM products
           INNER JOIN categorys ON products.cid = categorys.cid
           ORDER BY c_name ASC ";
            $result = $conn->query($Selectsql);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '
                            <tr>
                                <td>' . $i++ . '</td>
                                <td>' . $row['p_name'] . '</td>
                                <td>' . $row['c_name'] . '</td>
                                <td>' . $row['p_model'] . '</td>
                                <td>' . $row['p_brand'] . '</td>
                                <td>' . $row['p_description'] . '</td>
                                <td>' . $row['p_stockQuantity'] . '</td>
                                <td>' . $row['p_price'] . '</td>
                                <td><img class="Product_table_image" src="' . $row['p_imageURL'] . '"></td>
                                <td>
                                    <!-- Edit Button -->
                                    <form action="product_edit.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="pid" value="' . $row["pid"] . '">
                                        <button style="width:100% !important; margin:2px;" type="submit" name="edit_product_btn" class="btn btn-warning btn-sm">EDIT</button>
                                    </form>
                                    <!-- Delete Button -->
                                    <form action="product.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="pid" value="' . $row["pid"] . '">
                                        <button style="width:100% !important; margin:2px;" type="submit" name="delete_product" class="btn btn-danger btn-sm">DELETE</button>
                                    </form>
                                </td>
                            </tr>
                        ';
                }
            } else {
                echo '<tr><td colspan="10" class="text-center">No products found</td></tr>';
            }
            $conn->close(); // Close the database connection
            ?>
        </tbody>
    </table>
    <script>
        document.getElementById('ProductImageurl').addEventListener('input', function () {
            var imageUrl = this.value;
            document.getElementById('productImage').src = imageUrl;
        });

    </script>




    <?php include "./layout/footer.php" ?>