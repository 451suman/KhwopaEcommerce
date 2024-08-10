<?php
function title($title)
{
    return $title;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php $title = title($title);
    echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/bootswagger.css">
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.js"></script>
    <style>
        .modal-content {
            background-color: white !important;
        }

        .form-floating input {
            background-color: white !important;
            color: black !important;
        }

        .form-floating label {
            color: black !important;
        }

        .formBtnPadding {
            margin-left: 5px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">Navbar</a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active_nav" href="./home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active_nav" href="./categorys.php">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active_nav" href="./aboutus.php">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active_nav" href="#">Contact</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <!-- signup modal button -->
                        <button type="button" class="btn btn-primary formBtnPadding" data-bs-toggle="modal"
                            data-bs-target="#signup">
                            Signup
                        </button>
                    </li>
                    <li class="nav-item">
                        <!-- login modal button -->
                        <button type="button" class="btn btn-primary formBtnPadding" data-bs-toggle="modal"
                            data-bs-target="#login">
                            Login
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="bg-secondary">
        <div id="main_body">