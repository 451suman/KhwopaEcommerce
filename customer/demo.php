<?php 
include "./layout/header.php";
include "./layout/customer_session.php";
include "../database/db.php";
 // Adjust path as needed

if (isset($_GET['category_single']) && isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $products = category_product_display($cid, $conn);
    
    if ($products) {
        while ($product = $products->fetch_assoc()) {
            // Debug output to see available keys
            // echo '<pre>' . print_r($product, true) . '</pre>';
            
            // Display product details
            echo ($product['p_name']) . '<br>';
            echo ($product['p_model']) . '<br>';
            echo ($product['p_brand']) . '<br>';
            echo ($product['p_description']) . '<br>';
            echo ($product['p_price']) . '<br>';
            echo ($product['p_stockQuantity']) . '<br>';
            echo ($product['p_imageURL']) . '<br>';
        }
    }
}

include "./layout/footer.php";
?>
