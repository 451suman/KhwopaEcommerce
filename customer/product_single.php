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
    $price=$row['p_price'];
  }
}
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6">
      <div class="">
        <img style="height:450px" src="../image/product/<?php echo $row['p_image']; ?>" class="d-block w-100"
          alt="Sweatshirt Image 1">
      </div>
    </div>
    <div class="col-md-6">
      <h2><p class="text-primary">Product Name: <?php echo $row['p_name']; ?> </p></h2>
      <h3><p class="text-primary"><strong>Price=</strong> Rs <?php echo $row['p_price']; ?></p></h3>
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
                <input type="number" class="form-control bg-info" id="quantity" name="Quantity" min="1" max="<?php echo $row['p_stocksQuantity']; ?>" value="1">
            </div>
        </div>
        <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
        <button type="submit" class="btn btn-primary" name="BUT_IT">BUY IT</button>
    </div>
</form>
<p id="totalprice" class="text-danger" style="font-size: 30px;"></p>


      <div class="row mt-5">
      </div>
    </div>
  </div>
</div>
<hr>

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


<?php include "./layout/footer.php" ?>