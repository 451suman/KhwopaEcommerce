<?php
include "../database/db.php";
function selectStocks($pid, $conn)
{
        $sql = "SELECT stocks.sid, stocks.pid, stocks.s_quantity, stocks.s_in_out, stocks.s_entryDate,
                stocks.s_productPrice, products.cid, products.p_name, products.p_model, products.p_brand,
                products.p_description, products.p_price, products.p_stocksQuantity, products.p_image, categorys.c_name
            FROM stocks
            INNER JOIN products ON products.pid = stocks.pid
            INNER JOIN categorys ON products.cid = categorys.cid
            WHERE stocks.pid = $pid
             ORDER BY stocks.s_entryDate DESC
            ";

    $result = $conn->query($sql);
    return $result;
}

function selectStocksBUY($pid, $conn)
{
        $sql = "SELECT stocks.sid, stocks.pid, stocks.s_quantity, stocks.s_in_out, stocks.s_entryDate,
                stocks.s_productPrice, products.cid, products.p_name, products.p_model, products.p_brand,
                products.p_description, products.p_price, products.p_stocksQuantity, products.p_image, categorys.c_name
            FROM stocks
            INNER JOIN products ON products.pid = stocks.pid
            INNER JOIN categorys ON products.cid = categorys.cid
            WHERE stocks.pid = $pid AND stocks.s_in_out = 0
             ORDER BY stocks.s_entryDate DESC 
            ";

    $result = $conn->query($sql);
    return $result;
}

function selectStocksSELL($pid, $conn)
{
        $sql = "SELECT stocks.sid, stocks.pid, stocks.s_quantity, stocks.s_in_out, stocks.s_entryDate,
                stocks.s_productPrice, products.cid, products.p_name, products.p_model, products.p_brand,
                products.p_description, products.p_price, products.p_stocksQuantity, products.p_image, categorys.c_name
            FROM stocks
            INNER JOIN products ON products.pid = stocks.pid
            INNER JOIN categorys ON products.cid = categorys.cid
            WHERE stocks.pid = $pid AND stocks.s_in_out = 1
            ORDER BY stocks.s_entryDate DESC
            ";

    $result = $conn->query($sql);
    return $result;
}
?>
