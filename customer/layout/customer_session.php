<?php
session_start();
echo $_SESSION["users"];
die();
// if (!isset($_SESSION["users"])) {
//     header("Location: ../welcomepage/home.php");
//     exit();
// } else {
//     $uid = $_SESSION["users"];
//     echo "User ID: " . $uid; // Debug output
//     die();
// }
?>
