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

$conn->close(); // Close the database connection
?>


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
        <form action="home.php" method="post">
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
            <input name="phone" type="text" class="form-control" id="floatingInputPhoneSignup" placeholder="Phone">
            <label for="floatingInputPhoneSignup">Phone</label>
          </div>
          <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control" id="floatingInputPasswordSignup"
              placeholder="Password">
            <label for="floatingInputPasswordSignup">Password</label>
          </div>
          <div class="form-floating mb-3">
            <input name="district" type="text" class="form-control" id="floatingInputPasswordSignup"
              placeholder="District">
            <label for="floatingInputPasswordSignup">District</label>
          </div>
          <div class="form-floating mb-3">
            <input name="city" type="text" class="form-control" id="floatingInputPasswordSignup" placeholder="City">
            <label for="floatingInputPasswordSignup">City</label>
          </div>
          <div class="modal-footer">
            <button type="submit" name="signup_submit" class="btn btn-primary">Signup</button>
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
        <form action="home.php" method="post">
          <div class="form-floating mb-3">
            <input name="email" type="email" class="form-control" id="floatingInputEmailLogin" placeholder="Email">
            <label for="floatingInputEmailLogin">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control" id="floatingInputPasswordLogin"
              placeholder="Password">
            <label for="floatingInputPasswordLogin">Password</label>
          </div>
          <div class="modal-footer">
            <button type="submit" name="login_submit" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
        <!-- Login form ends -->
      </div>
    </div>
  </div>
</div>
<!-- Login modal end -->





<div class="card card_float" style="width: 18rem;">
  <img
    src="https://images.unsplash.com/photo-1521093470119-a3acdc43374a?q=80&w=1651&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
<div class="card card_float" style="width: 18rem;">
  <img
    src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
    </p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>




<?php include "./layout/footer.php" ?>