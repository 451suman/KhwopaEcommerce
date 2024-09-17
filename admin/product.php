<?php include "./layout/header.php";
include "./layout/admin_session.php";
?>
<div class="backencode">
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
                            msg_loc("error", "Error deleting old uploaded image.", "product.php");
                        }
                    }
                } else {
                    // Error moving the uploaded file
                    msg_loc("error", "Error moving uploaded image.", "product.php");
                    $edit_image_file = $old_image;
                }
            } else {
                // File size exceeds limit
                msg_loc("error", "File size exceeds the 5MB limit.", "product.php");
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
            msg("success", "Update successful.");
        } else {
            msg("error", "Update Failed.");
        }

        // Close the statement
        $stmt->close();
    }
    // EDIT PRODUCT back end
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
                        msg("success", "Product added into Database Successfully.");
                    } else {
                        msg("error", "Failed to add Product into Database.");

                    }
                } else {
                    msg("error", "Error moving uploaded file.");
                }
            } else {
                msg("error", "File size exceeds the maximum limit.");
            }
        } else {
            msg("error", "No file uploaded or there was an error uploading the file.");
        }
    }
    ?>
    <!-- // end add product -->


    <!-- // delete product -->
    <?php
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
                        msg("success", "Delete products form Database Successfully.");
                    } else {
                        msg("error", "Delete products form Database Failed.");
                    }
                }
            }
        }

    }
    ?>
    <!-- // delete product end -->


</div>


<div class="functions">
    <?php
    function productsView($conn)
    {
        $Selectsql = "SELECT products.pid, products.p_stocksQuantity, products.cid, products.p_name, products.p_model, 
        products.p_brand, products.p_description, products.p_price, products.p_dateAndTime, products.p_image,
            categorys.c_name
            FROM products
            INNER JOIN categorys ON products.cid = categorys.cid
            ORDER BY products.p_stocksQuantity ASC";
        // Execute the query
        $r = $conn->query($Selectsql);
        return $r;
    }
    function productsSearchView($conn, $searchTerm)
    {
        // Sanitize the search term to prevent SQL injection
        $searchTerm = $conn->real_escape_string($searchTerm);

        // Define the SQL query
        $Selectsql = "SELECT products.pid, products.p_stocksQuantity, products.cid, products.p_name, products.p_model, 
            products.p_brand, products.p_description, products.p_price, products.p_dateAndTime, products.p_image,
            categorys.c_name
            FROM products
            INNER JOIN categorys ON products.cid = categorys.cid
            WHERE (products.p_name LIKE '%$searchTerm%' 
            OR products.p_description LIKE '%$searchTerm%')
            ORDER BY products.p_stocksQuantity ASC";

        // Execute the query
        $r = $conn->query($Selectsql);
        return $r;
    }

    ?>
</div>
<!-- search form backend  -->

<!-- search form backend  -->

<div class="container mt-4">

    <?php
    include 'productpage/products_add_Create.php';
    include 'productpage/products_page_Search.php';
    ?>
    <h2>Product Management</h2>
    <!-- Product Table -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th width="2%">SN</th>
                <th width="5%">Name</th>
                <th width="5%">Category</th>
                <th width="5%">Model No</th>
                <th width="5%">Brand</th>
                <th width="42%">Description</th>
                <th width="10%">Stock Left</th>
                <th width="5%">Price</th>
                <th width="10%">Image</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryTable">


            <?php
            // search form of product .ph of admin pane data comes from productpagefolder/product addsearch ehich is includen inline 196 and 197
            if (isset($_GET["search_form"])) {

                $search = $_GET["search"];
                $result = productsSearchView($conn, $search);
            } else {
                $result = productsView($conn);
            }
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
                        echo ' 
                        <form action="stockManagement_update.php"  method="post">
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
                        echo ' <form action="stockManagement_insert.php"   method="post" >
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
                echo '<tr><td colspan="10" class=" bg-danger bg-opacity-25 text-center">No products found</td></tr>';
            }
            $conn->close(); // Close the database connection
            ?>
        </tbody>
    </table>

    <?php include "./layout/footer.php" ?>