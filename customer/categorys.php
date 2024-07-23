<?php 
include "./layout/header.php";

include "./layout/customer_session.php";
include "../database/db.php";
?>

<?php
$Selectsql="SELECT * FROM categorys";
$result=$conn ->query($Selectsql);
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {

        echo'
            <div class="card  bg-secondary category_card_customer mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="'.$row['c_img_url'].'" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                   
                    <p class="card-text"><strong>'.$row['c_name'].'</strong></p>
                 
                </div>
                </div>
            </div>
            </div>
        ';

    }
}


?>


<button type="button" class="btn btn-primary"> <a href=""> View </a> </button>


<?php include "./layout/footer.php" ?>