<?php 
include "./layout/header.php";

include "./layout/customer_session.php";

?>


<?php
session_start();

if (isset($_SESSION['users'])) {
    // Unset the 'member' session variable
    unset($_SESSION['users']);

    session_destroy();

    header("Location: ../welcomepage/home.php");
    exit;
}
?>



<?php include "./layout/footer.php" ?>