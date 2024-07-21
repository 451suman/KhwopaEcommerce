<?php
session_start();

if (!isset($_SESSION["users"])) {
    header("Location: ../welcomepage/home.php");
    exit();
} else {
    $aid = $_SESSION["users"];
   
}
?>
