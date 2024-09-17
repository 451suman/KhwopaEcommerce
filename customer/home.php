<?php
include "./layout/header.php";
include "./layout/customer_session.php";

// Connect to the database
$conn = new mysqli("localhost", "root", "", "khwopa");

// Function to fetch a user's order history
function getUserOrders($conn, $userId)
{
  // Fix the query to join orders with products to get the category
  $query = "SELECT orders.pid, categorys.c_name 
            FROM orders
            JOIN products ON orders.pid = products.pid
            JOIN categorys ON products.cid = categorys.cid
            WHERE orders.uid = $userId";
  
  $result = $conn->query($query);

  $orderedCategories = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $orderedCategories[$row['pid']] = $row['c_name'];
    }
  }
  return $orderedCategories;
}

// Function to fetch all products and their categories
function getAllProducts($conn)
{
  // Fix the query to properly join products with categories
  $query = "SELECT products.pid, products.p_name, products.p_brand, products.p_model, 
                   products.p_stocksQuantity, products.p_price, products.p_image, categorys.c_name 
            FROM products
            JOIN categorys ON products.cid = categorys.cid";
  
  $result = $conn->query($query);

  $allProducts = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $allProducts[] = $row;
    }
  }
  return $allProducts;
}

// Function to get recommendations based on user orders
function recommendProducts($orderedCategories, $allProducts)
{
  $recommendations = [];
  foreach ($allProducts as $product) {
    if (in_array($product['c_name'], $orderedCategories)) {
      $recommendations[] = $product;
    }
  }
  return $recommendations;
}

// Usage Example
$userId = $uid;  // Example user ID
$orderedCategories = getUserOrders($conn, $userId);
$allProducts = getAllProducts($conn);

// Get recommendations
$recommendedProducts = recommendProducts($orderedCategories, $allProducts);

?>

<div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
  <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
    <!-- Loop through recommended products -->
    <?php foreach ($recommendedProducts as $product): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <!-- Product Image -->
          <img src="../image/product/<?php echo $product['p_image']; ?>" class="card-img-top" alt="Product Image">

          <div class="card-body">
            <!-- Product Name -->
            <h5 class="card-title bg-primary text-light" style="text-align:center;">
              <strong><?php echo htmlspecialchars($product['p_name']); ?></strong>
            </h5>

            <!-- Product Description (Model, etc.) -->
            <p class="card-text">
              <strong>Brand:</strong> <?php echo htmlspecialchars($product['p_brand']); ?><br>
              <strong>Model No:</strong> <?php echo htmlspecialchars($product['p_model']); ?><br>
              <strong>Stock Quantity:</strong> <?php echo htmlspecialchars($product['p_stocksQuantity']); ?>  <br>
              <strong>category:</strong> <?php echo  htmlspecialchars($product['c_name']); ?>
            </p>
            <p class="card-text text-primary" style="text-align: center; font-size: 20px;">
              <strong>Price:</strong> <?php echo 'Rs ' . htmlspecialchars($product['p_price']); ?> <br>
            </p>

            <!-- Action Button -->
            <div class="text-center my-4">
              <a href="product_single.php?pid=<?php echo $product['pid']; ?>" class="btn btn-primary">Check offer</a>
            </div>

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
    <?php endforeach; ?>
  </div>
</div>

<?php
$conn->close();
include "./layout/footer.php";
?>
