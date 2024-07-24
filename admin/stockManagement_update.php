<?php include "./layout/header.php";
include "./layout/admin_session.php";

?>

<?php
if(isset($_POST['update_submit_stocks']))
{
    $pid=$_POST['pid'];
    $old_quantity=$_POST['old_quantity'];
    $addtional_quantity=$_POST['addtional_quantity'];
    $p_name=$_POST['p_name'];
    $new_quantity = $old_quantity + $addtional_quantity;
    // echo $new_quantity;
    // echo "old stock= ".$old_quantity."new Stock= ".$addtional_quantity."<br>";
    // echo "after addition =" .$old_quantity + $addtional_quantity;
    // die();
    $sql="INSERT INTO stocks (pid, s_quantity, s_entryDate, s_balanceQuantity) 
    VALUES ('$pid', '$addtional_quantity', current_timestamp(), '$new_quantity')";
    if($conn->query($sql))
    {
        $icon = "success";
        $msg = "Update Stock Of " . $p_name . " id Successfull";
        $loc = "product.php";
        msg_loc($icon, $msg, $loc);
    }
    else{
        $icon = "error";
        $msg = "Insert Stock Failed Of " . $p_name . " ";
        $loc = "product.php";
        msg_loc($icon, $msg, $loc);
    }
}

?>


<?php

     if (isset($_POST['update_stocks_btn'])) {
        $sid = $_POST["sid"];
        $pid = $_POST["pid"];
        $s_quantity = $_POST["s_quantity"];
        $s_balanceQuantity = $_POST["s_balanceQuantity"];
        


        $sql = "SELECT products.pid, products.cid, products.p_name, products.p_model, products.p_brand,
                products.p_description, products.p_price,products.p_dateAndTime,products.p_image,
                categorys.c_name
                FROM products
                INNER JOIN categorys ON products.cid = categorys.cid
                ORDER BY p_dateAndTime DESC ";
                if ($result = $conn->query($sql)) {
                    $row = $result->fetch_assoc();
                }
       
    }


?>

<div class="container text-center">
    <div class="row align-items-start">
        <div class="col">
            <p class="alert-primary" style="color:white; font-size:20px;"><strong>Image</strong></p>
            <img id="productImage" src="../image/product/<?php echo $row['p_image']; ?>" alt="Product Image"
                class="img-fluid">
        </div>
        <div class="col">
            <form method="post" action="stockManagement_update.php">

                <p class="alert-primary" style="color:white; font-size:20px;"><strong>Insert Product Stock
                        Quantity</strong></p>
                <p style="font-size:20px;"><strong>Product Name : </strong><?php echo $row['p_name']; ?></p>
                <p style="font-size:20px;"><strong>Category Name : </strong><?php echo $row['c_name']; ?></p>
                <p style="font-size:20px;"><strong>Model no : </strong><?php echo $row['p_model']; ?></p>
                <p style="font-size:20px;"><strong>Brand : </strong><?php echo $row['p_brand']; ?></p>
                <p style="font-size:20px;"><strong>Price : </strong><?php echo $row['p_price']; ?></p>
                <p style="font-size:20px;"><strong>Description : </strong><?php echo $row['p_description']; ?></p>
                
                <div>
                    <label for="" class="form-label mt-4"><strong>Old Stock Quantity</strong></label>
                    <input type="number" name="old_quantity" class="form-control" min="0" value="<?php echo $s_balanceQuantity;  ?>" readonly>
                </div>
                <div>
                    <label for="" class="form-label mt-4"><strong>Enter a New Additional Stock Quantity</strong></label>
                    <input type="number" name="addtional_quantity" class="form-control" min="0" id="uqntity">
                </div>

                <br>
                <input type="hidden" name="pid" value="<?php echo $pid; ?>" id="">
                <input type="hidden" name="p_name" value="<?php echo $row['p_name']; ?>" id="">
                <button type='submit' name='update_submit_stocks' class='btn btn-primary'>update</button>



            </form>
        </div>

    </div>
</div>



<?php include "./layout/footer.php" ?>