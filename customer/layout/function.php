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

    $sql = "SELECT * FROM products
             WHERE cid = $cid && p_stocksQuantity > 0";
    $result = $conn->query($sql);
    return $result;
}

function selectProducts($conn) //from products.php page -> products.php ma jancha
{
    $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, products.p_price,
     products.p_stocksQuantity, products.p_image,
    categorys.c_name
    FROM products
    INNER JOIN categorys ON products.cid = categorys.cid
    WHERE p_stocksQuantity > 0
    ORDER BY categorys.c_name ASC";
    $result = $conn->query($Selectsql);
    return $result;

}
?>

<!-- ORDER BY RAND() -->