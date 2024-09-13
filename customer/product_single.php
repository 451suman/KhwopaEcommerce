<?php
include "./layout/header.php";

include "./layout/customer_session.php";

?>


<?php
//review comment and rating backend
if (isset($_POST['review_submit'])) {
  $pid = mysqli_real_escape_string($conn, $_POST['pid']);
  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $review_msg = mysqli_real_escape_string($conn, $_POST['review_msg']);
  $rating = mysqli_real_escape_string($conn, $_POST['rating']);
  // echo $pid . "  /" . $uid . "  /" . $review_msg . " rat=" . $rating;
//   die();
  $sql_review = "INSERT INTO reviews (uid, pid, r_ratingValue, r_comment, r_revievStatus) 
                  VALUES ('$uid', '$pid', '$rating', '$review_msg', '0')";
  $result = $conn->query($sql_review);
  if ($result) {
    msg_loc("success", "Thank you for Review", "product_single.php?pid=$pid");
  } else {
    msg_loc("error", " Review failed", "product_single.php");
  }
}
//review comment and rating backend ends
?>

<?php
// passing pid from products.php using <a  href="product_single.php?pid='.$row['pid'].'" class="btn btn-primary"> tag
if (isset($_GET["pid"])) {
  $pid = $_GET["pid"];
  $Selectsql = "SELECT * FROM products
   WHERE pid=$pid";
  $result = $conn->query($Selectsql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $price = $row['p_price'];
  }
}
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6">
      <div class="" style="border:1px solid black !important">
        <img style="height:450px" src="../image/product/<?php echo $row['p_image']; ?>" class="d-block w-100"
          alt="Sweatshirt Image 1">
      </div>
    </div>
    <div class="col-md-6">
      <h2>
        <p class="text-primary">Product Name: <?php echo $row['p_name']; ?> </p>
      </h2>
      <h3>
        <p class="text-primary"><strong>Price=</strong> Rs <?php echo $row['p_price']; ?></p>
      </h3>
      <!-- <p><strong>Category</strong>: < ?php echo $row['cid']; ?></p> -->
      <p><strong>Model no </strong>: <?php echo $row['p_model']; ?></p>
      <p><strong>Brand</strong> : <?php echo $row['p_brand']; ?></p>
      <p><strong>Left in Stocks</strong> : <?php echo $row['p_stocksQuantity']; ?></p>
      <p><strong>Description</strong> : <?php echo $row['p_description']; ?></p>
      <div class="options">
      </div>
      <hr>
      <form action="orderConformationPage.php" method="get">
        <div class="container mt-4">
          <div class="row mb-3">
            <label for="quantity" class="col-sm-3 col-form-label  "><strong>Select Quantity</strong></label>
            <div class="col-sm-9">
              <input type="number" class="form-control bg-info" id="quantity" name="Quantity" min="1"
                max="<?php echo $row['p_stocksQuantity']; ?>" value="1">
            </div>
          </div>
          <p id="totalprice" class="text-danger" style="font-size: 30px;"></p>
          <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
          <button type="submit" class="btn btn-primary" name="BUT_IT">BUY IT</button>
        </div>
      </form>

      <!-- calculate price JS -->
      <script>
        var price = <?php echo $price; ?>;
        var quantityElement = document.getElementById("quantity");
        var totalPriceElement = document.getElementById("totalprice");
        function calculateTotal() {
          var quantity = parseInt(quantityElement.value);
          var cal = price * quantity;
          totalPriceElement.innerHTML = "Total Price: " + cal;
        }
        calculateTotal();
        // Add an event listener to recalculate when the quantity changes input = tag
        quantityElement.addEventListener("input", calculateTotal);
      </script>

      <div class="row mt-5">
      </div>
    </div>
  </div>
</div>
<hr>


<div class="container text-center">
  <div class="row align-items-start">
<!-- col 1 -->
    <div class="col">
      <p class="alert-primary edit_headings" style="color: white; font-size: 20px;">Average Ratings</p>

      <div class="container-fluid">
        <div class="card mb-3 p-2" style="width: 100%;">
          <div class="row g-0">
            <div class="col-md-12">
              <div class="card-body" style="text-align: center;">
                <?php
                // Initialize variables for calculating the average
                $total_rating = 0;
                $rating_count = 0;

                // Retrieve all the ratings for the product
                $stmt = $conn->prepare("SELECT r_ratingValue FROM reviews WHERE pid = ?");
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $result = $stmt->get_result();

                // Sum all the ratings and count the number of ratings
                while ($row = $result->fetch_assoc()) {
                  $total_rating += $row['r_ratingValue'];
                  $rating_count++;
                }

                // Calculate the average rating
                if ($rating_count > 0) {
                  $average_rating = $total_rating / $rating_count; 
                } else {
                  $average_rating = null;
                }

                // Create the star string based on the average rating
                $star_rating = '';
                if ($average_rating !== null) {
                  // Round the average rating to the nearest whole number
                  $rounded_rating = round($average_rating);
                  echo "<p style='font-size:20px; margin:0px;'><strong>".$rounded_rating."</strong></p>";
                  // Generate the star string
                  for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rounded_rating) {
                      $star_rating .= '⭐'; // Full star
                    } else {
                      $star_rating .= '☆'; // Empty star
                    }
                  }
                } else {
                  $star_rating = '☆ ☆ ☆ ☆ ☆'; // In case there are no ratings
                }

                // Display the star rating
                echo "<div style='font-size: 38px;'>$star_rating</div>";

                ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>


    <!-- review form -->
    <?php

    // Check if the order exists for the given product and user
    $order_check_sql = "SELECT * FROM orders WHERE pid=$pid AND uid=$uid";
    $result2 = $conn->query($order_check_sql);

    if ($result2->num_rows != 0) {
      $row2 = $result2->fetch_assoc();

      // Proceed only if the order status is 'completed'
      if ($row2['o_orderStatus'] == 'completed') {

        // Check if the user has already reviewed the product
        $sql_check_review = "SELECT * FROM reviews WHERE pid=$pid AND uid=$uid";
        $result = $conn->query($sql_check_review);

        if ($result->num_rows > 0) {
          // Fetch the review details
          $row = $result->fetch_assoc();
          $rating = '';
          for ($i = 1; $i <= $row['r_ratingValue']; $i++) {
            $rating .= "⭐"; // Use .= for string concatenation
          }

          // col 2 review  if review is already given
          echo '
            <div class="col">
                <p class="alert-primary edit_headings" style="color: white; font-size: 20px;">YOUR REVIEW OF THIS PRODUCT</p>
                 <div class="container-fluid">
                    <div class="card mb-3 p-2" style="width: 100%;">
                      <div class="row g-0">
                        <div class="col-md-12">
                          <div class="card-body" style="text-align: center;">
                            <p>Comment<br>' . $row['r_comment'] . ' <br> 
                            <span>Rating: ' . $rating . '</span></p>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            ';
        } else {
          // Review comment and rating star form.
          echo '
            <div class="col">
                <p class="alert-primary edit_headings" style="color: white; font-size: 20px;">GIVE REVIEW OF THIS PRODUCT</p>
                <form id="reviewForm" method="post" action="product_single.php" style="border:1px solid black; padding:10px;" class="bg-info">
                    <div>
                        <input type="text" name="review_msg" class="form-control" placeholder="Review this product" required>
                        <br>
                        <label for="rating">Rating:</label>
                        <div class="rating">
                            <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                            <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                            <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                            <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                            <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                        </div>
                        <input type="hidden" name="pid" value="' . $pid . '">
                        <input type="hidden" name="uid" value="' . $uid . '">
                        <input type="submit" class="btn btn-primary" value="SUBMIT REVIEW" name="review_submit" id="review_btn_id">
                    </div>
                </form>
                <br>
            </div>
            ';
        }
      }
    }
    ?>
    <!-- https://bbbootstrap.com/snippets/bootstrap-rate-your-experience-template-star-ratings-30972576# -->
    <!-- review form ends -->
  </div>
</div>
<br>
<hr>




<!-- review and rating  display rating startshere -->
<?php
$select_review = "SELECT users.uid, users.first_name, users.last_name, reviews.rid, reviews.uid AS review_uid, reviews.pid, reviews.r_ratingValue, 
                  reviews.r_comment, reviews.r_revievStatus,  reviews.r_dateAndTime
                 FROM reviews 
                 INNER JOIN users ON users.uid = reviews.uid
                 WHERE reviews.pid = $pid 
                 ORDER BY reviews.r_ratingValue DEsc";

$result = $conn->query($select_review);


if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    ?>
    <div class="container-fluid">
      <div class="card mb-3 p-2" style="width: 100%;">
        <div class="row g-0">
          <div class="col-md-12">
            <div class="card-body">
              <h5 class="card-title text-success"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h5>
              <?php
              // Display star rating based on the r_ratingValue
              for ($i = 0; $i < $row['r_ratingValue']; $i++) {
                echo '⭐';
              }
              ?>
              <p class="card-text text-justify">
                <?php echo htmlspecialchars($row['r_comment']); ?>
              </p>
              <p class="card-text"><small class="text-body-secondary">
                  <?php echo date("F j, Y, g:i a", strtotime($row['r_dateAndTime'])); ?>
                </small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
} else {
  echo "";
}
?>
<!-- review and display rating ends here -->




<?php include "./layout/footer.php" ?>