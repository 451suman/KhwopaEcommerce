<?php
include "../database/db.php";

// form category.php page bata -> products.php ma jancha
function category_product_display($cid, $conn)
{
    $cid = intval($cid);
    if ($cid <= 0) {
        echo '<p>Invalid category ID.</p>';
        return null;
    }

    $sql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, products.p_price,
     products.p_stocksQuantity, products.p_image,
    categorys.c_name
    FROM products
    INNER JOIN categorys ON products.cid = categorys.cid
    WHERE categorys.cid = $cid && products.p_stocksQuantity > 0";
    $result = $conn->query($sql);
    return $result;
}

function selectProducts($conn)
{
    // Use prepared statements for security
    $sql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, 
                   products.p_price, products.p_stocksQuantity, products.p_image, categorys.c_name
            FROM products
            INNER JOIN categorys ON products.cid = categorys.cid
            WHERE products.p_stocksQuantity > 0
            ORDER BY categorys.c_name ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}

// Function to search products
function SearchFunction($searchTerm, $conn) {
    // Escape the search term to prevent SQL injection
    $searchTerm = $conn->real_escape_string($searchTerm);

    // Construct the SQL query
    $query = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, 
                     products.p_price, products.p_stocksQuantity, products.p_image, categorys.c_name
              FROM products
              INNER JOIN categorys ON products.cid = categorys.cid
              WHERE products.p_stocksQuantity > 0 
                AND (products.p_name LIKE '%$searchTerm%' 
                OR products.p_description LIKE '%$searchTerm%')";

    // Execute the query
    $result = $conn->query($query);

    // Return the result
    return $result;
}



?>

<!-- ORDER BY RAND() -->