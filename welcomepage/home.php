<?php
$title = "Home";
?>
<?php include "./layout/header.php";
include "../database/db.php";
?>



<!-- signup back end -->
<?php
if (isset($_POST["signup_submit"])) {
  // Adjust the path as needed

  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $district = $_POST["district"];
  $city = $_POST["city"];
  $password = $_POST["password"];
  $hashed_password = md5($password);


  $error = [];

  // Validate first name
  if (empty($fname)) {
    $error['fname'] = "Please enter a first name";
  } elseif (strlen($fname) > 20) {
    $error['fname'] = "The first name should not exceed more than 20 characters in length.";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
    $error['fname'] = "First name should only contain letters and spaces.";
  }

  // Validate last name
  if (empty($lname)) {
    $error['lname'] = "Please enter a last name";
  } elseif (strlen($lname) > 20) {
    $error['lname'] = "The last name should not exceed more than 20 characters in length.";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
    $error['lname'] = "Last name should only contain letters and spaces.";
  }

  // Validate email
  if (empty($email)) {
    $error['email'] = "Please enter an email address";
  } elseif (strlen($email) > 30) {
    $error['email'] = "The email address should not exceed more than 30 characters in length.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error['email'] = "Please enter a valid email address";
  } else {
    // Check for duplicate email in the database
    $check_duplicate = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_duplicate);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $error['email'] = "Email already registered";
    }
    $stmt->close();
  }

  // Validate phone number
  if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
    $error['phone'] = "Please enter a valid 10-digit phone number";
  }

  // Validate password
  if (empty($password)) {
    $error['password'] = "Please enter a password";
  } elseif (strlen($password) !== 10) {
    $error['password'] = "Password must be exactly 10 characters long";
  }

  if (!empty($error)) {
    echo '<script>';
    echo 'var errorMessage = "";';
    foreach ($error as $errorMsg) {
      echo "errorMessage += '$errorMsg. ';";
    }
    echo "Swal.fire({
            title: 'Signup Error!',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: 'OK'
        });";
    echo '</script>';

  } else {
    // Check if there are existing users to determine role
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // For user: who registers from the second time
      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone, role, district, city) VALUES (?, ?, ?, ?, ?, '1', ?, ?)");
    } else {
      // For admin: the first person who registers
      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone, role, district, city) VALUES (?, ?, ?, ?, ?, '0', ?, ?)");
    }

    // Bind parameters: s = string, i = integer
    $stmt->bind_param("sssssss", $fname, $lname, $email, $hashed_password, $phone, $district, $city);


    if ($stmt->execute()) {
      echo '<script>';
      echo "Swal.fire({
                title: 'Signup Successful!',
                text: 'You have been registered successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'home.php'; // Redirect to login page
                }
            });";
      echo '</script>';
    } else {
      echo '<script>';
      echo "Swal.fire({
                title: 'Signup Error!',
                text: 'Error: " . $stmt->error . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });";
      echo '</script>';
    }

    $stmt->close();
    $conn->close();
  }
}
?>
<!-- login back end -->

<?php
// Start the session at the beginning
session_start(); // Ensure session_start is at the beginning of the file

if (isset($_POST["login_submit"])) {
  $e = $_POST["email"];
  $p = md5($_POST["password"]);

  // Assuming $conn is your database connection
  $sql = "SELECT * FROM users WHERE email='$e' AND password='$p'";
  $r = $conn->query($sql);

  if ($r->num_rows > 0) {
    $row = $r->fetch_assoc();

    $uid = $row['uid'];
    $role = $row['role'];

    // Set session variable
    $_SESSION["users"] = $uid;

    // Redirect based on role
    if ($role == 0) {
      header("Location: ../admin/home.php");
      exit();
    }
    if ($role == 1) {
      header("Location: ../customer/home.php");
      exit();
    }
  } else {
    echo '<script>';
    echo "Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username or password is incorrect!',
            })";
    echo '</script>';
  }
}

// Close the database connection
?>


<!-- carousel start from here -->

<div class="carousel_image_div">
  <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <?php for ($i = 1; $i <= 44; $i++) { ?>

        <div class="carousel-item <?php echo $i === 1 ? 'active' : ''; ?>" data-bs-interval="10000">
          <img class="carousel_image_slide d-block w-100" src="../image/product/product_image_1723222698.jpg"
            alt="Product Image <?php echo $i; ?>">
          <div class="carousel-caption d-none d-md-block">
            <h5><?php echo $i;?></h5>
            <p class="text-warning"> <br> placeholder content for <br> the first slide.</p>
          </div>
        </div>

      <?php } ?>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>




<div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
  <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">


    <!-- loop here -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <!-- Product Image -->
        <img src="../image/product/product_image_1723222698.jpg" class="card-img-top">


        <div class="card-body">
          <!-- Product Name -->
          <h5 class="card-title bg-primary text-light" style="text-align:center;">
            <!-- <strong><?php echo $row['p_name']; ?></strong> -->
            name
          </h5>

          <!-- Product Description (Model, etc.) -->
          <p class="card-text">
            <strong>Brand:</strong>
            < ?php echo $row['p_brand']; ?><br>
              <strong>Model No:</strong>
              < ?php echo $row['p_model']; ?><br>
                <strong>Stock Quantity:</strong>
                < ?php echo $row['p_stocksQuantity']; ?>

          </p>
          <p class="card-text text-primary" style="text-align: center; font-size: 20px;">
            <strong>Price:</strong>
            < ?php echo 'Rs ' . $row['p_price']; ?>
          </p>

          <!-- Action Button -->
          <div class="text-center my-4">
            <a href="product_single.php?pid=< ?php echo $row['pid']; ?>" class="btn btn-primary">Checkoffer</a>
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
  </div>
</div>




<?php include "./layout/footer.php" ?>