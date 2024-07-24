<?php include "./layout/header.php";
    include "./layout/admin_session.php";

?>



<?php include "./layout/footer.php" ?>


<!-- echo '<script>';
    echo "Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username or password is incorrect!',
            })";
    echo '</script>'; -->

    <!-- $Selectsql = "SELECT products.pid, products.cid, products.p_name, products.p_color, products.p_brand, products.p_description, products.p_price, products.p_stockQuantity, products.p_imageURL,
           categorys.c_name
           FROM products
           INNER JOIN categorys ON products.cid = categorys.cid
           ORDER BY c_name ASC "; -->