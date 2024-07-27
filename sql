 $product_update = "UPDATE products SET p_stocksQuantity = '$leftStockQuantity' WHERE pid = $pid";

        $stock_insert = "INSERT INTO stocks (pid, s_quantity, s_in_out, s_entryDate, s_productPrice) 
        VALUES ('$pid', ' $quantity', '1', current_timestamp(), '$total_price')";
        $stockRes = $conn->query($stock_insert);
        $productRes = $conn->query($product_update);