<?php 
$title = "Category";
?>
<?php include "./layout/header.php";
include "../database/db.php";
?>
<?php

// Query to select categories
$Selectsql = "SELECT * FROM categorys";
$result = $conn->query($Selectsql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
            <div class="card bg-light category_card_customer mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="../image/category/' . $row['c_img'] . '" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <p class="card-text"><strong>' . $row['c_name'] . '</strong></p>
                    <form action="home.php" method="get">
                        <input type="hidden" name="cid" value="' . $row['cid']. '">
                        <input type="submit" class="btn btn-primary" name="category_single" value="View">
                    </form>
                </div>
                </div>
            </div>
            </div>
        ';
    }
} else {
    echo "No categories found.";
}


?>
<?php include "./layout/footer.php" ?>