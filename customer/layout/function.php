<?php
include "../database/db.php";
function category_product_display($cid, $conn)
{
    $cid = intval($cid);
    if ($cid <= 0) {
        echo '<p>Invalid category ID.</p>';
        return null;
    }

    $sql = "SELECT * FROM products WHERE cid = $cid";
    $result = $conn->query($sql);
    return $result;
}

function selectProducts($conn)
{
    $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, products.p_price, products.p_stockQuantity, products.p_imageURL,
    categorys.c_name
    FROM products
    INNER JOIN categorys ON products.cid = categorys.cid
    ORDER BY categorys.c_name ASC";
    $result = $conn->query($Selectsql);
    return $result;

}
?>