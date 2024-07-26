<?php
include "./layout/header.php";

include "./layout/customer_session.php";

?>

<?php
// passing pid from products.php using <a  href="product_single.php?pid='.$row['pid'].'" class="btn btn-primary"> tag
if (isset($_GET["pid"])) {
    $pid = $_GET["pid"];
    $Selectsql = "SELECT * FROM products WHERE pid=$pid";
    $result = $conn->query($Selectsql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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
            <h2>Name: <?php echo $row['p_name']; ?> </h2>
            <p class="price"><strong>Price=</strong> Rs <?php echo $row['p_price']; ?></p>
            <p><strong>Model no </strong>: <?php echo $row['p_model']; ?></p>
            <p><strong>Brand</strong> : <?php echo $row['p_brand']; ?></p>
            <p><strong>Description</strong> : <?php echo $row['p_description']; ?></p>
            <div class="options">
            </div>
            <hr>
            <button class="btn btn-primary mt-4">BUY IT</button>
            <div class="row mt-5">
            </div>
        </div>
    </div>
</div>
<hr>
<?php include "./layout/footer.php" ?>