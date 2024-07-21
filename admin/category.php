<?php include "./layout/header.php";
include "./layout/admin_session.php";
include "../database/db.php";
?>


<div class="container mt-4">
    <h2>Category Management</h2>


    <?php
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
        if(isset($_POST['delete_category'])){
            $cid = $_POST["cid"];
           $deleteSql="DELETE FROM categorys WHERE cid = $cid";
           $result=$conn->query($deleteSql);
           if($result)
           {
            echo '<script>';
            echo "Swal.fire({
                        icon: 'success',
                        text: 'Delete Category form Database Successfully.',
                    })";
            echo '</script>';
           }else{
            echo '<script>';
            echo "Swal.fire({
                        icon: 'error',
                        text: 'Delete Category form Database Failed.',
                    })";
            echo '</script>';
           }
        }
        // delete category end
        
        // edit/update category
        if(isset($_POST["edit_category_submit"]))
        {
            $c_name=$_POST['c_name'];
            $cid=$_POST['cid'];
            $c_img_url=$_POST['c_img_url'];


            $updateSql= "UPDATE categorys SET c_name = '$c_name', c_img_url = '$c_img_url' WHERE cid =  $cid";
            $result=$conn->query($updateSql);
            if($result)
            {
                echo '<script>';
                echo "Swal.fire({
                            icon: 'success',
                            text: 'Update Category in Database Succcessfully .',
                        })";
                echo '</script>';
            }
            else{
                echo '<script>';
                echo "Swal.fire({
                            icon: 'error',
                            text: 'Failed to update Category in Database',
                        })";
                echo '</script>';
            }
        }
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
                            <label for="categoryImageurl" class="form-label">Image URL Address</label>
                            <input type="url" name="url" class="form-control" id="categoryName" placeholder="Paste Image Address Here" required>

                        </div>

                        <button type="submit" name="category_submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Category Modal ends -->



    <!-- Category Table -->
    <table class="table table-bordered table-striped" >
        <thead>
            <tr>
                <th width="10%" >SN</th>
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
                            <td> <img class="category_table_image" src="'.$row['c_img_url'].'" ></td>
                            <td>
                                <!-- Edit Button -->
                               <button style="width:100% !important; margin:2px;" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EDITCategoryModal" 
                                        data-id="' . $row['cid'] . '" data-name="' . $row['c_name'] . '" data-url="' . $row['c_img_url'] . '">
                                    Edit
                                </button>
                        
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


<!-- Edit Category Modal -->
<div class="modal fade" id="EDITCategoryModal" tabindex="-1" aria-labelledby="EDITCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EDITCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


            <form id="editCategoryForm" method="post" action="category.php">
                    <input type="hidden" name="cid" id="editCategoryId">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Category Name</label>
                        <input type="text" name="c_name" class="form-control" id="editCategoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategoryUrl" class="form-label">Category Image URL</label>
                        <input type="url" name="c_img_url" class="form-control" id="editCategoryUrl" required>
                    </div>
                    <button type="submit" name="edit_category_submit" class="btn btn-primary">Update Category</button>
                </form>


            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal ends -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('EDITCategoryModal');

    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var url = button.getAttribute('data-url');

        // Populate the modal with data
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryUrl').value = url;
    });
});
</script>



<?php include "./layout/footer.php" ?>