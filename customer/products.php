<?php 
include "./layout/header.php";

include "./layout/customer_session.php";
include "../database/db.php";

?>

<?php

$Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand, products.p_price, products.p_stockQuantity, products.p_imageURL,
categorys.c_name
FROM products
INNER JOIN categorys ON products.cid = categorys.cid
ORDER BY c_name ASC ";
$result = $conn->query($Selectsql);
if ($result->num_rows > 0) {
  $i = 1;
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="card card_float" style="width: 18rem; border:3px solid black;">
        <img src="'.$row['p_imageURL'].'" class="card-img-top" alt="Card image">
        <div class="card-body">
            <h5 class="card-title"><p class="text-warning" style=" text-align: center;font-size: 20px;"><strong>'.$row['p_name'].' </strong> </p> </h5><hr>
            <p class="card-text">
              <strong> Brand=  </strong> '.$row['p_brand'].'<br> 
              <strong> Color=  </strong> '.$row['p_color'].'<br>
              <strong> Description = </strong> '.$row['p_description'].'
            </p>
            <hr>
            <p class="card-text text-primary" style=" text-align: center; font-size: 20px;"><strong>
            price= '.$row['p_price'].'
          
           </strong> </p>
            <a  href="product_single.php?pid='.$row['pid'].'" class="btn btn-primary">View Details</a>
        </div>
    </div>
';


  }
}

?>

<form action=""></form>

<?php include "./layout/footer.php" ?>