<?php 
include "./layout/header.php";
include "./layout/customer_session.php";
include "../database/db.php";
// Ensure this path is correct

if (isset($_GET['category_single']) && isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $result = category_product_display($cid, $conn);
} else {
    $result = selectProducts($conn);
}

// Check if $result is not null before using it
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="card bg-secondary card_float" style="width: 18rem;">
            <img src="'.$row['p_imageURL'].'" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title"><strong>'.$row['p_name'].'</strong></h5>
                <p class="card-text">
                  <strong>Brand=</strong> '.$row['p_brand'].'<br> 
                  <strong>Model no=</strong> '.$row['p_model'].'<br>
                </p>
                <p class="card-text" style="text-align: center; font-size: 20px;"><strong>
                Price= Rs '.$row['p_price'].'
                </strong></p>
                <a href="product_single.php?pid='.$row['pid'].'" class="btn btn-primary">View Details</a>
            </div>
        </div>
      ';
    }
} else {
    echo '<p>No products available.</p>';
}
?>
<?php include "./layout/footer.php" ?>
