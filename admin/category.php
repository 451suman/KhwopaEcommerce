<?php include "./layout/header.php";
include "./layout/admin_session.php";

?>


<div class="container mt-4">
    <h2>Category Management</h2>




    <?php


    


    // add category
    if (isset($_POST["category_submit"])) {
        $c_name = $_POST["c_name"];

        if (isset($_FILES["category_image"]["name"])) {
            $file_name = $_FILES["category_image"]["name"];
            $file_size = $_FILES["category_image"]["size"];
            $file_tmp = $_FILES["category_image"]["tmp_name"];
            $fileType = pathinfo($file_name, PATHINFO_EXTENSION);

            $newFileName = "category_image_" . time() . '.' . $fileType;
            $destination = "../image/category/" . $newFileName;

            if ($file_size < 5242880) { // Max file size: 5MB
                if (move_uploaded_file($file_tmp, $destination)) {
                    $Insertsql = "INSERT INTO categorys (c_name,c_img) VALUES ( '$c_name','$newFileName')";
                    $result = $conn->query($Insertsql);
                    if ($result) {
                        $icon = "success";
                        $msg = "Category added into Database Successfully.";
                        msg($icon, $msg);
                    } else {
                        $icon = "error";
                        $msg = "Failed to add Category into Database..";
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
    // end ad category
    
    // delete category
    if (isset($_POST['delete_category'])) {
        $cid = $_POST["cid"];

        $imgSQL = "SELECT * FROM categorys WHERE cid = $cid";
        if ($imgResult = $conn->query($imgSQL)) {
            $row = $imgResult->fetch_assoc();
            $img_name = $row['c_img'];
            $folderPath = '../image/category/';
            $filePath = $folderPath . $img_name;
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    $deleteSql = "DELETE FROM categorys WHERE cid = $cid";
                    $result = $conn->query($deleteSql);
                    if ($result) {
                        $icon = "success";
                        $msg = "Delete Category form Database Successfully.";
                        msg($icon, $msg);
                    } else {
                        $icon = "error";
                        $msg = "Delete Category form Database Failed.";
                        msg($icon, $msg);
                    }
                }
            }
        }



    }
    // delete category end
    ?>
    <!-- Add Category Button -->
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
    </div>
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="category.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" name="c_name" class="form-control" id="categoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryurl" class="form-label">Upload Image</label>
                            <input type="file" name="category_image" class="form-control" id="categoryImage"
                                accept=".jpg,.png,.jpeg" required>
                        </div>



                        <button type="submit" name="category_submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Category Modal ends -->

    <!-- Category Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="10%">SN</th>
                <th width="35%">Name</th>
                <th width="30%">Image</th>

                <th width="25%">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryTable">
            <?php
            $Selectsql = "Select * from categorys";
            $result = $conn->query($Selectsql);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    // Starting index
                    echo '
                        <tr>
                            <td>' . $i++ . '</td>
                            <td>' . $row['c_name'] . '</td>
                            <td> <img class="category_table_image" src="../image/category/' . $row['c_img'] . '" ></td>
                            <td>
                                <!-- Edit Button -->
                               <form action="category_edit.php" method="post">
                                    <input type="hidden" name="cid" value="' . $row["cid"] . '" id="">
                                    <button style="width:100% !important;margin:2px;" type="submit" name="edit_btn_category" class="btn btn-warning">EDIT</button>
                                </form>
                        
                                <!-- Delete Button -->
                               <form action="category.php" method="post">
                                    <input type="hidden" name="cid" value="' . $row["cid"] . '" id="">
                                    <button style="width:100% !important;margin:2px;" type="submit" name="delete_category" class="btn btn-danger">Delete</button>
                                </form>
                               
                            </td>
                        </tr>
                        ';
                }
            }
            ?>
        </tbody>
    </table>
</div>


<!-- // Edit/update category -->
<?php
    if (isset($_POST["edit_category_submit"])) {
      
        // Sanitize input
        $c_name =$_POST['c_name'];
        $cid = $_POST['cid'];
        $old_image = $_POST['old_image'];

        $edit_image_file = $old_image;

        if (!empty($_FILES["new_image_file"]["name"])) {
            $file_name = $_FILES["new_image_file"]["name"];
            $file_size = $_FILES["new_image_file"]["size"];
            $file_tmp = $_FILES["new_image_file"]["tmp_name"];
            $fileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_types = ['jpg', 'jpeg', 'png'];
            if (in_array($fileType, $allowed_types)) {
                $newFileName = "category_image_" . time() . '.' . $fileType;
                $destination = "../image/category/" . $newFileName;

                $file_size_limit = 5242880; // 5MB
                if ($file_size <= $file_size_limit) {
                    if (move_uploaded_file($file_tmp, $destination)) {
                        // Successfully moved the uploaded file
                        $edit_image_file = $newFileName;

                        // Delete old image if it exists
                        $old_img_path = '../image/category/' . $old_image;
                        if (file_exists($old_img_path) && $old_image !== '') {
                            if (!unlink($old_img_path)) {
                                $icon = "error";
                                $msg = "Error deleting old uploaded image.";
                                $loc = "category.php";
                                msg_loc($icon, $msg, $loc);
                                exit;
                            }
                        }
                    } else {
                        // Error moving the uploaded file
                        $icon = "error";
                        $msg = "Error moving uploaded image.";
                        $loc = "category.php";
                        msg_loc($icon, $msg, $loc);
                        exit;
                    }
                } else {
                    // File size exceeds limit
                    $icon = "error";
                    $msg = "File size exceeds the 5MB limit.";
                    $loc = "category.php";
                    msg_loc($icon, $msg, $loc);
                    exit;
                }
            } else {
                // Invalid file type
                $icon = "error";
                $msg = "Invalid file type. Only jpg, jpeg, and png files are allowed.";
                $loc = "category.php";
                msg_loc($icon, $msg, $loc);
                exit;
            }
        }

        // Update category
        $updateSql = "UPDATE categorys SET c_name = ?, c_img = ? WHERE cid = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ssi", $c_name, $edit_image_file, $cid);

        if ($stmt->execute()) {
            $icon = "success";
            $msg = "The category has been updated.";
            $loc = "category.php";
            msg_loc($icon, $msg, $loc);
        } else {
            $icon = "error";
            $msg = "Failed to update the category.";
            $loc = "category.php";
            msg_loc($icon, $msg, $loc);
        }

        $stmt->close();
        $conn->close();
    }
    ?>

<?php include "./layout/footer.php" ?>