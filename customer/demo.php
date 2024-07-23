<?php 
include "./layout/header.php";
include "./layout/customer_session.php";
include "../database/db.php";
include "../layout/functions.php"; // Adjust path as needed

if (isset($_GET['category_single']) && isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $products = category_product_display($cid, $conn);
    
    if ($products) {
        while ($product = $products->fetch_assoc()) {
           echo $product['p_name'];
        }
    }
}

include "./layout/footer.php";
?>
