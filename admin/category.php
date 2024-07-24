<?php include "./layout/header.php";
include "./layout/admin_session.php";

?>


<div class="container mt-4">
    <h2>Category Management</h2>


    <?php

    // Edit/update category
if (isset($_POST["edit_category_submit"])) {
    $c_name = $_POST['c_name'];
    $cid = $_POST['cid'];
    $c_img_url = $_POST['c_img_url'];

    // Sanitize inputs to prevent SQL injection
    $c_name = $conn->real_escape_string($c_name);
    $c_img_url = $conn->real_escape_string($c_img_url);

    $updateSql = "UPDATE categorys SET c_name = '$c_name', c_img_url = '$c_img_url' WHERE cid = $cid";
    $result = $conn->query($updateSql);
    if ($result) {
        echo '<script>';
        echo 'Swal.fire({
                    icon: "success",
                    title: "Updated Successfully!",
                    text: "The category has been updated.",
                }).then(function() {
                    window.location = "category.php";
                });';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: "Failed to update the category.",
                }).then(function() {
                    window.location = "category.php";
                });';
        echo '</script>';
    }
}
    // add category
    if (isset($_POST["category_submit"])) {
        $c_name = $_POST["c_name"];
        $url = $_POST["url"];


        $Insertsql = "INSERT INTO categorys (c_name,c_img_url) VALUES ( '$c_name','$url')";
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
    // end ad category
    
    // delete category
    if (isset($_POST['delete_category'])) {
        $cid = $_POST["cid"];
        $deleteSql = "DELETE FROM categorys WHERE cid = $cid";
        $result = $conn->query($deleteSql);
        if ($result) {
            echo '<script>';
            echo "Swal.fire({
                        icon: 'success',
                        text: 'Delete Category form Database Successfully.',
                    })";
            echo '</script>';
        } else {
            echo '<script>';
            echo "Swal.fire({
                        icon: 'error',
                        text: 'Delete Category form Database Failed.',
                    })";
            echo '</script>';
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
                    <form id="addCategoryForm" method="post" action="category.php">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" name="c_name" class="form-control" id="categoryName" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryurl" class="form-label">Image URL Address</label>
                            <input type="url" name="url" class="form-control" id="categoryurl"
                                placeholder="Paste Image Address Here" required>
                        </div>

                        <div class="col">
                            <!-- Display product image -->
                            <img id="productImage" style="height: 200px;" src="" alt="Product Image" class="img-fluid">
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
                            <td> <img class="category_table_image" src="' . $row['c_img_url'] . '" ></td>
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

<script>
    document.getElementById('categoryurl').addEventListener('input', function () {
        var imageUrl = this.value;
        document.getElementById('productImage').src = imageUrl;
    });
</script>

<?php include "./layout/footer.php" ?>