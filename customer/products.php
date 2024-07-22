<?php 
include "./layout/header.php";

include "./layout/customer_session.php";
include "../database/db.php";

?>

<?php

$Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_color, products.p_brand, products.p_description, products.p_price, products.p_stockQuantity, products.p_imageURL,
categorys.c_name
FROM products
INNER JOIN categorys ON products.cid = categorys.cid
ORDER BY c_name ASC ";
$result = $conn->query($Selectsql);
if ($result->num_rows > 0) {
  $i = 1;
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="card card_float" style="width: 18rem;">
        <img src="'.$row['p_imageURL'].'" class="card-img-top" alt="Card image">
        <div class="card-body">
            <h5 class="card-title"><strong>'.$row['p_name'].' </strong> </h5>
            <p class="card-text">
              <strong> Brand=  </strong> '.$row['p_brand'].'<br> 
              <strong> Color=  </strong> '.$row['p_color'].'<br>
              <strong> Description = </strong> '.$row['p_description'].'
            </p>
            <p class="card-text text-primary" style=" text-align: center;font-size: 20px;"><strong>
            price= '.$row['p_price'].'
           </strong> </p>
            <a  href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
';


  }
}

?>




<?php include "./layout/footer.php" ?>