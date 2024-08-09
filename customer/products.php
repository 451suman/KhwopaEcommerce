<?php
include "./layout/header.php";
include "./layout/customer_session.php";



if (isset($_GET['category_single']) && isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $result = category_product_display($cid, $conn);
} else {
    $result = selectProducts($conn);
}
?>






    <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
        <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
            <?php
            // Check if $result is not null before using it
            if ($result && $result->num_rows > 0) {
                       
                while ($row = $result->fetch_assoc()) {
                    ?>

                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <!-- Product Image -->
                            <img src="../image/product/<?php echo $row['p_image']; ?>" class="card-img-top"
                                alt="<?php echo $row['p_name']; ?>">
                            <div class="card-body">
                                <!-- Product Name -->
                                <h5 class="card-title bg-primary text-light" style="text-align:center;">
                                    <strong><?php echo $row['p_name']; ?></strong>
                                </h5>

                                <!-- Product Description (Model, etc.) -->
                                <p class="card-text">
                                    <strong>Brand:</strong> <?php echo $row['p_brand']; ?><br>
                                    <strong>Model No:</strong> <?php echo $row['p_model']; ?><br>
                                    <strong>Stock Quantity:</strong> <?php echo $row['p_stocksQuantity']; ?>
                                </p>
                                <p class="card-text text-primary" style="text-align: center; font-size: 20px;">
                                    <strong>Price:</strong> <?php echo 'Rs ' . $row['p_price']; ?>
                                </p>

                                <!-- Action Button -->
                                <div class="text-center my-4">
                                    <a href="product_single.php?pid=<?php echo $row['pid']; ?>" class="btn btn-primary">View Details</a>
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

                    <?php
                }


            } else {
                echo '<p>No products available.</p>';
            }
            ?>





        </div>
    </div>


<?php include "./layout/footer.php" ?>