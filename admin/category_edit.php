<?php
include "./layout/header.php";
include "./layout/admin_session.php";




// Fetch category details for editing
if (isset($_POST['edit_btn_category'])) {
    $cid = $_POST['cid'];
    $cid = $conn->real_escape_string($cid); // Sanitize input

    $selectSql = "SELECT * FROM categorys WHERE cid = $cid";
    $result = $conn->query($selectSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Handle the case where the category is not found
        echo '<p>Category not found.</p>';
        exit;
    }
}
?>

<div class="container text-center">
    <div class="row align-items-start">
        <div class="col">
            <div class="mb-3">
                <!-- Display the category image -->
                <img id="categoryImage" style="height: 500px;" src="<?php echo htmlspecialchars($row['c_img_url']); ?>" alt="Category Image" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
        </div>
        <div class="col">
            <form method="post" action="category.php">
                <div class="mb-3">
                    <label for="editCategoryName" class="form-label">Category Name</label>
                    <input type="text" name="c_name" value="<?php echo htmlspecialchars($row['c_name']); ?>" class="form-control" id="editCategoryName" required>
                </div>
                <div class="mb-3">
                    <label for="editCategoryUrl" class="form-label">Category Image URL</label>
                    <input type="url" name="c_img_url" class="form-control" value="<?php echo htmlspecialchars($row['c_img_url']); ?>" id="editCategoryUrl" placeholder="Paste Image Address Here" required>
                </div>
                <input type="hidden" name="cid" value="<?php echo $cid; ?>" id="editCategoryId">
                <button type="submit" name="edit_category_submit" class="btn btn-primary">Update Category</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('editCategoryUrl').addEventListener('input', function () {
        var imageUrl = this.value;
        document.getElementById('categoryImage').src = imageUrl;
    });
</script>

<?php include "./layout/footer.php"; ?>
