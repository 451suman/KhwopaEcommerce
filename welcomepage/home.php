<?php include"./layout/header.php";
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
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

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







<div class="card card_float" style="width: 18rem;">
  <img src="demo.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
<div class="card card_float" style="width: 18rem;">
  <img src="demo.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>




<?php include"./layout/footer.php" ?>