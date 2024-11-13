<?php include "./layout/header.php";
include "./layout/admin_session.php";
?>
<!-- count total no of customers -->
<?php
  // Correct the SQL query syntax
  $sql = "SELECT COUNT(uid) FROM users WHERE role = 1"; 
  $result = $conn->query($sql);

  // Fetch the result
  if ($result) {
      $count = $result->fetch_row()[0]; // Assuming the first column holds the count
  } else {
      $count = 0; // In case of query failure
  }
?>



<center>
  <h1>Customer Details </h1>
</center>
<div > <h3>Total Customer: <span class="text-danger"><?php echo $count; ?></h3></span></div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">sn</th>
      <th scope="col"> Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Address</th>
    </tr>
  </thead>
  <tbody>

    <?php
    $selectUser = "SELECT * FROM users WHERE role = 1";
    $result = $conn->query($selectUser);

    if ($result->num_rows > 0) {
      $i = 0;
      while ($row = $result->fetch_assoc()) {
        $i++;
        echo '
            <tr>
              <th scope="row">' . $i . '</th>
              <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
              <td>' . $row["email"] . '</td>
              <td>' . $row["phone"] . '</td>
              <td>' . $row["district"] . ', ' . $row["city"] . '</td>
            </tr>
          ';

      }
    }


    ?>




  </tbody>
</table>

<?php include "./layout/footer.php" ?>