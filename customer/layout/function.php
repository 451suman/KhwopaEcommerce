<?php
include "../database/db.php"; // Adjust path as needed

function category_product_display($cid) {
    global $conn; // Use the global $conn variable to access the database connection

    // Validate the category ID
    $cid = intval($cid);
    if ($cid <= 0) {
        echo '<p>Invalid category ID.</p>';
        return;
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM products WHERE category_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are results
        if ($result->num_rows > 0) {
            echo '<h1>Products in Category ' . htmlspecialchars($cid) . '</h1>';
            while ($row = $result->fetch_assoc()) {
                echo '
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="' . htmlspecialchars($row['product_img_url']) . '" class="img-fluid rounded-start" alt="Product Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="card-text"><strong>' . htmlspecialchars($row['product_name']) . '</strong></p>
                                    <p class="card-text">Price: $' . htmlspecialchars($row['product_price']) . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '<p>No products found in this category.</p>';
        }

        $stmt->close();
    } else {
        echo '<p>Error preparing the SQL statement.</p>';
    }
}
?>
