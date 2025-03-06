<?php include "./layout/header.php";
include"./layout/admin_session.php";

?>

<h1> RECOMMENDATION FOR YOU Costomer Home Page.</h1>
<div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
  <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
    <?php

    // SQL query
    $sql = "SELECT 
            products.p_name, products.p_brand, products.p_model, 
            products.p_stocksQuantity, products.p_price, products.p_image,
            categorys.c_name, products.pid,
            AVG(reviews.r_ratingValue) AS avg_rating
        FROM 
            products
        JOIN 
            categorys ON products.cid = categorys.cid
        LEFT JOIN 
            reviews ON products.pid = reviews.pid
        GROUP BY 
            products.pid, products.p_name, categorys.c_name
        ORDER BY 
            avg_rating DESC
          LIMIT 8";

    $result = $conn->query($sql);

    if ($result === false) {
      echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
      // Output each product
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <!-- Product Image -->
            <img src="../image/product/<?php echo $row['p_image']; ?>" class="card-img-top"
              alt="<?php echo $row['p_name']; ?>">
            <div class="card-body">
              <!-- Product Name -->
              <h5 class="card-title bg-primary text-light text-center">
                <strong><?php echo $row['p_name']; ?></strong>
              </h5>

              <!-- Product Description (Model, etc.) -->
              <p class="card-text">
                <strong>Brand:</strong> <?php echo $row['p_brand']; ?><br>
                <strong>Model No:</strong> <?php echo $row['p_model']; ?><br>
                <strong>Stock Quantity:</strong> <?php echo $row['p_stocksQuantity']; ?><br>
                <strong>Category:</strong> <?php echo $row['c_name']; ?>
              </p>
              <p class="card-text text-primary text-center" style="font-size: 20px;">
                <strong>Price:</strong> <?php echo 'Rs ' . $row['p_price']; ?>
              </p>

              <!-- Average Rating -->
              <p class="card-text text-warning text-center" style="font-size: 18px;">
                <strong>Average Rating:</strong> <?php echo number_format($row['avg_rating'], 0); ?> / 5
              </p>

             
              <!-- Optional Footer Icons -->
              <div class="clearfix mb-1">
                <span class="float-start">
                  <i class="far fa-question-circle"></i>
                </span>
                <span class="float-end">
                  <i class="fas fa-plus"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p>No products found.</p>";
    }

    $conn->close();
    include "./layout/footer.php";
    ?>