<?php include "./layout/header.php";
include "./layout/admin_session.php";
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
        $old_image = $_POST['old_image'];

        $edit_image_file = $old_image; // Default to old image if no new image is uploaded
    
        if (!empty($_FILES["new_image_file"]["name"])) {
            $file_name = $_FILES["new_image_file"]["name"];
            $file_size = $_FILES["new_image_file"]["size"];
            $file_tmp = $_FILES["new_image_file"]["tmp_name"];
            $fileType = pathinfo($file_name, PATHINFO_EXTENSION);

            $newFileName = "product_image_" . time() . '.' . $fileType;
            $destination = "../image/product/" . $newFileName;

            $file_size_limit = 5242880; // 5MB
            if ($file_size < $file_size_limit) {
                if (move_uploaded_file($file_tmp, $destination)) {
                    // Successfully moved the uploaded file
                    $edit_image_file = $newFileName;

                    // Delete old image
                    $old_img_path = '../image/product/' . $old_image;
                    if (file_exists($old_img_path)) {
                        if (!unlink($old_img_path)) {
                            $icon = "error";
                            $msg = "Error deleting old uploaded image.";
                            $loc = "product.php";
                            msg($icon, $msg);
                        }
                    }
                } else {
                    // Error moving the uploaded file
                    $icon = "error";
                    $msg = "Error moving uploaded image.";
                    $loc = "product.php";
                    msg_loc($icon, $msg, $loc);
                    $edit_image_file = $old_image;
                }
            } else {
                // File size exceeds limit
                $icon = "error";
                $msg = "File size exceeds the 5MB limit.";
                $loc = "product.php";
                msg_loc($icon, $msg, $loc);
                $edit_image_file = $old_image;
            }
        }

        // Prepare SQL statement for updating product
        $updateSql = "UPDATE products 
                    SET p_name = ?, cid = ?, p_model = ?, p_brand = ?, p_description = ?, p_price = ?, p_image = ? 
                    WHERE pid = ?";

        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param('sisssssi', $p_name, $category, $model, $brand, $description, $price, $edit_image_file, $pid);

        // Execute the statement
        if ($stmt->execute()) {
            $icon = "success";
            $msg = "Update successful.";
            msg($icon, $msg);
        } else {
            $icon = "error";
            $msg = "Update Failed.";
            msg($icon, $msg);
        }

        // Close the statement
        $stmt->close();
    }
    ?>

    <!-- // Add product -->
    <?php

    if (isset($_POST["Product_submit"])) {
        $category = $_POST["category"];
        $p_name = $_POST["p_name"];
        $model = $_POST["model"];
        $brand = $_POST["brand"];
        $description = $_POST["description"];
        $price = $_POST["price"];

        // Check if file was uploaded
        if (isset($_FILES["image_file"])) {
            $file_name = $_FILES["image_file"]["name"];
            $file_size = $_FILES["image_file"]["size"];
            $file_tmp = $_FILES["image_file"]["tmp_name"];
            $fileType = pathinfo($file_name, PATHINFO_EXTENSION);

            $newFileName = "product_image_" . time() . '.' . $fileType;
            $destination = "../image/product/" . $newFileName;

            if ($file_size < 5242880) { // Max file size: 5MB
                if (move_uploaded_file($file_tmp, $destination)) {
                    $Insertsql = "INSERT INTO products (cid, p_name, p_model, p_brand, p_description, p_price, p_image)
                              VALUES ('$category', '$p_name', '$model', '$brand', '$description', '$price', '$newFileName')";

                    $result = $conn->query($Insertsql);

                    if ($result) {
                        $icon = "success";
                        $msg = "Product added into Database Successfully.";
                        msg($icon, $msg);
                    } else {
                        $icon = "error";
                        $msg = "Failed to add Product into Database.";
                        msg($icon, $msg);

                    }
                } else {
                    $icon = "error";
                    $msg = "Error moving uploaded file.";
                    msg($icon, $msg);
                }
            } else {
                $icon = "error";
                $msg = "File size exceeds the maximum limit.";
                msg($icon, $msg);
            }
        } else {
            $icon = "error";
            $msg = "No file uploaded or there was an error uploading the file.";
            msg($icon, $msg);
        }
    }
    ?>
    <!-- // end add product -->

    <?php
    // delete product
    if (isset($_POST['delete_product'])) {
        $pid = $_POST["pid"];
        $imgSQL = "SELECT * FROM products WHERE pid = '$pid'";
        $imgResult = $conn->query($imgSQL);
        if ($imgResult->num_rows > 0) {
            $row = $imgResult->fetch_assoc();
            $img_name = $row['p_image'];
            $folderPath = '../image/product/';
            $filePath = $folderPath . $img_name;
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deleteSql = "DELETE FROM products WHERE pid = $pid";
                    $result = $conn->query($deleteSql);
                    if ($result) {
                        $icon = "success";
                        $msg = "Delete products form Database Successfully.";
                        msg($icon, $msg);
                    } else {
                        $icon = "error";
                        $msg = "Delete products form Database Failed.";
                        msg($icon, $msg);
                    }
                }
            }
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


    <!-- Search  button -->
    <div style="margin-bottom:5px">
    <form class="d-flex " action="" method="">
        <input class="form-control bg-info me-sm-2" type="search" placeholder="Search">
        <button class="btn btn-primary my-2 my-sm-0"   type="submit">Search</button>
      </form>
    </div>
    <!-- Search  button -->


    <!-- Product Table -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th width="2%">SN</th>
                <th width="5%">Name</th>
                <th width="5%">Category</th>
                <th width="5%">Model No</th>
                <th width="5%">Brand</th>
                <th width="47%">Description</th>
                <th width="5%">Balance Quantity</th>
                <th width="5%">Price</th>
                <th width="10%">Image</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryTable">


            <?php
            
            $Selectsql = "SELECT products.pid, products.p_stocksQuantity, products.cid, products.p_name, products.p_model, 
            products.p_brand, products.p_description, products.p_price, products.p_dateAndTime, products.p_image,
                categorys.c_name
                FROM products
                INNER JOIN categorys ON products.cid = categorys.cid
                ORDER BY products.p_stocksQuantity ASC";

            $result = $conn->query($Selectsql);
            if ($result->num_rows > 0) {
                $i = 1;

                while ($row = $result->fetch_assoc()) {
                    // substr($row['p_description'], 0, 100) display only 100 character
                    echo '
                            <tr>
                                <td>' . $i++ . '</td>
                                <td>' . $row['p_name'] . '</td>
                                <td>' . $row['c_name'] . '</td>
                                <td>' . $row['p_model'] . '</td>
                                <td>' . $row['p_brand'] . '</td>
                            <td><p>' . substr($row['p_description'], 0, 300) . '...</p></td>
                                <td>' . $row['p_stocksQuantity'] . '</td>
                                <td>' . $row['p_price'] . '</td>
                                <td><img class="Product_table_image" src="../image/product/' . $row['p_image'] . '"></td>
                                <td>
                                <!--   edit button-->
                                    <form action="product_edit.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="pid" value="' . $row["pid"] . '">
                                        <button style="width:100% !important; margin:2px;" type="submit" name="edit_product_btn" class="btn btn-warning btn-sm">EDIT</button>
                                    </form>
                                    <!--delete button-->
                                    <form action="product.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="pid" value="' . $row["pid"] . '">
                                        <button style="width:100% !important; margin:2px;" type="submit" name="delete_product" class="btn btn-danger btn-sm">DELETE</button>
                                    </form>
                                    ';

                    //    <!-- stock update button-->
                    $pid = $row['pid'];

                    $stockSql = "SELECT * FROM `stocks` WHERE pid = $pid";
                    $check = $conn->query($stockSql);
                    if ($check->num_rows > 0) {
                        $row2 = $check->fetch_assoc();
                        echo ' <form action="stockManagement_update.php"  method="post">
                        <input type="hidden" name="pid" value="' . $row2["pid"] . '">
                        <input type="hidden" name="sid" value="' . $row2["sid"] . '">
                        <input type="hidden" name="s_quantity" value="' . $row2["s_quantity"] . '">
                        <input type="hidden" name="p_stocksQuantity" value="' . $row["p_stocksQuantity"] . '">
                      
                        <button style="width:100% !important; margin:2px;" type="submit" name="update_stocks_btn" class="btn btn-primary btn-sm">Update Stocks</button>
                    </form>
                    
                    <form action="stockDetails.php" method="get" >
                        <input type="hidden" name="pid" value="' . $row["pid"] . '">
                        <button style="width:100% !important; margin:2px;" type="submit" name="pid_product_page" 
                        class="btn btn-primary btn-sm">VIEW Stocks</button>
                    </form>

                    ';

                    } else {
                        echo ' <form action="stockManagement.php"   method="post" >
                                <input type="hidden" name="pid" value="' . $row["pid"] . '">
                                <button style="width:100% !important; margin:2px;" type="submit" name="insert_stocks_btn" 
                                class="btn btn-primary btn-sm">Insert Stocks</button>
                            </form>';
                    }
                    echo "   
                    


                            </td>
                                </tr>
                        ";
                }
            } else {
                echo '<tr><td colspan="10" class="text-center">No products found</td></tr>';
            }
            $conn->close(); // Close the database connection
            ?>
        </tbody>
    </table>
    <?php include "./layout/footer.php" ?>