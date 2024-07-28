<?php
include "./layout/header.php";

include "./layout/customer_session.php";

?>
<?php

if (isset($_GET['conform_order_btn'])) {
  $pid = $_GET['pid'];
  $sql = "INSERT INTO orders (oid, uid, pid, o_totalAmount, o_shippingAddress, o_orderStatus, o_quantity, o_date) 
  VALUES (NULL, '', '', '', '', '', '', current_timestamp())";
}


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
      <div class=""  style="border:1px solid black !important">
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
    <div class="col">
      <div style="margin-left: 10% !important;margin-right: 10%  !important;">
        <p class="alert-primary edit_headings" style="color: white; font-size: 20px;">TOTAL Ratings</p>
        <strong>Rating 5</strong>
        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <strong>Rating 4</strong>
        <div class="progress">
          <div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0"
            aria-valuemax="100"></div>
        </div>
        <strong>Rating 3</strong>
        <div class="progress">
          <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;" aria-valuenow="75"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <strong>Rating 2</strong>
        <div class="progress">
          <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <strong>Rating 1</strong>
        <div class="progress">
          <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="col">
      <p class="alert-primary edit_headings" style="color: white; font-size: 20px;">GIVE REVIEW OF PRODUCTS</p>
      <form style="border:1px solid black; padding:10px;" class="bg-info" action="">
        <div>
          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
          <br>
          <input type="submit" class="btn btn-primary" value="SUBMIT REVIEW" name="" id="">
        </div>
      </form>
      <br>


    </div>
  </div>
</div>
<br>
<hr><br>
<div style="margin-left: 10% !important;margin-right: 10%  !important;">

  <div style="border:1px solid black; padding:10px;">
    <p class="alert-primary edit_headings" style="color: white; font-size: 20px;">PRODUCT REVIEW</p>
    <!-- while{} -->
    <div style="border:1px solid red; padding:5px;margin:5px" class="bg-secondary ">
      <p class="text-primary" style="font-size:20px">Name of Customer</p>
      <p class="text-primary" style="font-size:20px">RATING = 5</p>
      <p class=" edit_headings" style="border:1px solid black; padding:10px;">Lorem ipsum dolor, sit amet
        consectetur adipisicing elit. Tempora illum voluptate praesentium quibusdam accusantium officia
        reprehenderit esse doloremque eveniet, corporis explicabo! Tenetur nam amet quasi voluptate eaque, minus
        necessitatibus, cupiditate consequuntur quae fugiat quibusdam dicta atque quod quam animi rerum corrupti
        quidem, assumenda quos voluptatum. Facere aperiam quis eaque repellendus.</p>
    </div>
    <div style="border:1px solid red; padding:5px;margin:5px" class="bg-secondary ">
      <p class="text-primary" style="font-size:20px">Name of Customer</p>
      <p class="text-primary" style="font-size:20px">RATING = 5</p>
      <p class=" edit_headings" style="border:1px solid black; padding:10px;">Lorem ipsum dolor, sit amet
        consectetur adipisicing elit. Tempora illum voluptate praesentium quibusdam accusantium officia
        reprehenderit esse doloremque eveniet, corporis explicabo! Tenetur nam amet quasi voluptate eaque, minus
        necessitatibus, cupiditate consequuntur quae fugiat quibusdam dicta atque quod quam animi rerum corrupti
        quidem, assumenda quos voluptatum. Facere aperiam quis eaque repellendus.</p>
    </div>
    <div style="border:1px solid red; padding:5px;margin:5px" class="bg-secondary ">
      <p class="text-primary" style="font-size:20px">Name of Customer</p>
      <p class="text-primary" style="font-size:20px">RATING = 5</p>
      <p class=" edit_headings" style="border:1px solid black; padding:10px;">Lorem ipsum dolor, sit amet
        consectetur adipisicing elit. Tempora illum voluptate praesentium quibusdam accusantium officia
        reprehenderit esse doloremque eveniet, corporis explicabo! Tenetur nam amet quasi voluptate eaque, minus
        necessitatibus, cupiditate consequuntur quae fugiat quibusdam dicta atque quod quam animi rerum corrupti
        quidem, assumenda quos voluptatum. Facere aperiam quis eaque repellendus.</p>
    </div>
    <div style="border:1px solid red; padding:5px;margin:5px" class="bg-secondary ">
      <p class="text-primary" style="font-size:20px">Name of Customer</p>
      <p class="text-primary" style="font-size:20px">RATING = 5</p>
      <p class=" edit_headings" style="border:1px solid black; padding:10px;">Lorem ipsum dolor, sit amet
        consectetur adipisicing elit. Tempora illum voluptate praesentium quibusdam accusantium officia
        reprehenderit esse doloremque eveniet, corporis explicabo! Tenetur nam amet quasi voluptate eaque, minus
        necessitatibus, cupiditate consequuntur quae fugiat quibusdam dicta atque quod quam animi rerum corrupti
        quidem, assumenda quos voluptatum. Facere aperiam quis eaque repellendus.</p>
    </div>
    <div style="border:1px solid red; padding:5px;margin:5px" class="bg-secondary ">
      <p class="text-primary" style="font-size:20px">Name of Customer</p>
      <p class="text-primary" style="font-size:20px">RATING = 5</p>
      <p class=" edit_headings" style="border:1px solid black; padding:10px;">Lorem ipsum dolor, sit amet
        consectetur adipisicing elit. Tempora illum voluptate praesentium quibusdam accusantium officia
        reprehenderit esse doloremque eveniet, corporis explicabo! Tenetur nam amet quasi voluptate eaque, minus
        necessitatibus, cupiditate consequuntur quae fugiat quibusdam dicta atque quod quam animi rerum corrupti
        quidem, assumenda quos voluptatum. Facere aperiam quis eaque repellendus.</p>
    </div>
    <div style="border:1px solid red; padding:5px;margin:5px" class="bg-secondary ">
      <p class="text-primary" style="font-size:20px">Name of Customer</p>
      <p class="text-primary" style="font-size:20px">RATING = 5</p>
      <p class=" edit_headings" style="border:1px solid black; padding:10px;">Lorem ipsum dolor, sit amet
        consectetur adipisicing elit. Tempora illum voluptate praesentium quibusdam accusantium officia
        reprehenderit esse doloremque eveniet, corporis explicabo! Tenetur nam amet quasi voluptate eaque, minus
        necessitatibus, cupiditate consequuntur quae fugiat quibusdam dicta atque quod quam animi rerum corrupti
        quidem, assumenda quos voluptatum. Facere aperiam quis eaque repellendus.</p>
    </div>
  </div>
</div>




<?php include "./layout/footer.php" ?>