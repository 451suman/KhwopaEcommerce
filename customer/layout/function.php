<?php
// Adjust path as needed
include "../database/db.php"; // Ensure this path is correct

function category_product_display($cid, $conn) {
    // Validate the category ID
    $cid = intval($cid);
    if ($cid <= 0) {
        echo '<p>Invalid category ID.</p>';
        return;
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM products WHERE cid = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo '<p>No products found for this category.</p>';
        }

        $stmt->close();
        $conn->close();
    } else {
        echo '<p>Error preparing the SQL statement.</p>';
    }
}
?>
