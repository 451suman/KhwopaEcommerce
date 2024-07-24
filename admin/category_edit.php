<?php
include "./layout/header.php";
include "./layout/admin_session.php";

// Fetch category details for editing
if (isset($_POST['edit_btn_category'])) {
    $cid = $_POST['cid'];

    $selectSql = "SELECT * FROM categorys WHERE cid = $cid";
    $result = $conn->query($selectSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<p>Category not found.</p>';
        exit;
    }
}
?>

<div class="container text-center">
    <div class="row align-items-start">
        <div class="col">
            <div class="mb-3">
                <p class="alert-primary edit_headings" style="color:white; font-size:20px;"> Current Using Image</p>
                <img id="categoryImage" style="height: 500px; margin-top:10px;"
                    src="../image/category/<?php echo $row['c_img']; ?>" alt="Category Image" class="img-fluid"
                    style="max-width: 100%; height: auto;">
            </div>
        </div>
        <div class="col">
            <p class="alert-primary edit_headings" style="color:white; font-size:20px;">Edit Category Details </p>
            <form method="post" action="category.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="editCategoryName" class="form-label">Category Name</label>
                    <input type="text" name="c_name" value="<?php echo $row['c_name']; ?>"
                        class="form-control" id="editCategoryName" required>
                </div>
                <div class="mb-3">
                    <label for="ProductImageurl" class="form-label">Upload Image (optional)</label>
                    <input type="file" name="new_image_file" class="form-control" id="ProductImageurl"
                        accept=".jpg,.png,.jpeg">
                </div>
                <input type="hidden" name="cid" value="<?php echo $cid; ?>" id="editCategoryId">
                <input type="hidden" name="old_image" value="<?php echo $row['c_img']; ?>">
                <button type="submit" name="edit_category_submit" class="btn btn-primary">Update Category</button>
            </form>

        </div>
    </div>
</div>


<?php include "./layout/footer.php"; ?>