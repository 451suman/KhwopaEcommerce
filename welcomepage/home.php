<?php
$title = "Home";
?>
<?php include "./layout/header.php";
include "../database/db.php";
include "functions.php";
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

<!-- signup back end -->

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
      header("Location: ../admin/ordersManagement.php");
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


?>
<!-- login back end -->








<!-- body products code  -->
<!-- data display code  -->

<?php
if (isset($_GET['category_single']) && isset($_GET['cid'])) {
  // customer/categorys.php vayeko specic cid vayeko button click vayo vane 
  $cid = $_GET['cid'];
  $result = category_product_display($cid, $conn);
  // customer/categorys.php vayeko specic cid vayeko button click vayo vane 

} else if (isset($_GET['search'])) {

  // nav bar bata search gareko 
  $searchTerm = $_GET['search'];
  $result = SearchFunction($searchTerm, $conn);
  // nav bar bata search gareko 

} else {
  // all product from product table 
  $result = selectProducts($conn);
  // all product from product table 
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
                <strong>Stock Quantity:</strong> <?php echo $row['p_stocksQuantity']; ?> <br>
                <strong>category:</strong> <?php echo $row['c_name']; ?>
              </p>
              <p class="card-text text-primary" style="text-align: center; font-size: 20px;">
                <strong>Price:</strong> <?php echo 'Rs ' . $row['p_price']; ?>
              </p>

              <!-- Action Button -->
              <div class="text-center my-4">
              <button type="button" class="btn btn-primary formBtnPadding" data-bs-toggle="modal"
                            data-bs-target="#login">
                            Details
                        </button>
              
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