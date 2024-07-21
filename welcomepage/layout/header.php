<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/bootswagger.css">
    <link rel="stylesheet" href="../css/custom.css">
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
        .formBtnPadding{
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
                        <a class="nav-link active" href="./home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./aboutus.php">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Contact</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <!-- signup modal button -->
                        <button type="button" class="btn btn-primary formBtnPadding" data-bs-toggle="modal" data-bs-target="#signup">
                            Signup
                        </button>
                    </li>
                    <li class="nav-item">
                            <!-- login modal button -->
                        <button type="button" class="btn btn-primary formBtnPadding" data-bs-toggle="modal" data-bs-target="#login">
                            Login
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Signup modal -->
    <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signupLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupLabel">Signup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Signup form -->
                    <form>
                        <div class="form-floating mb-3">
                            <input name="fname" type="text" class="form-control" id="floatingInputFName" placeholder="First Name">
                            <label for="floatingInputFName">First Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="lname" type="text" class="form-control" id="floatingInputLName" placeholder="Last Name">
                            <label for="floatingInputLName">Last Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInputEmailSignup" placeholder="Email">
                            <label for="floatingInputEmailSignup">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control" id="floatingInputPasswordSignup" placeholder="Password">
                            <label for="floatingInputPasswordSignup">Password</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Signup</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                    <!-- Signup form ends -->
                </div>
            </div>
        </div>
    </div>
    <!-- Signup modal end -->




    <!-- Login modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Login form -->
                    <form>
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInputEmailLogin" placeholder="Email">
                            <label for="floatingInputEmailLogin">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control" id="floatingInputPasswordLogin" placeholder="Password">
                            <label for="floatingInputPasswordLogin">Password</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Login</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                    <!-- Login form ends -->
                </div>
            </div>
        </div>
    </div>
    <!-- Login modal end -->

    <div id="main_body">