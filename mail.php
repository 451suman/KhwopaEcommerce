<?php
// Database connection credentials
$host = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "Khwopa"; // Your database name

// Admin email
$admin_email = "sumanmuahya@gmail.com"; // Change this to the admin's email

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products where p_stocksQuantity < 10
$sql = "SELECT p_name, p_stocksQuantity FROM products WHERE p_stocksQuantity < 10 AND p_stocksQuantity > 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Prepare email content
    $message = "The following products have stock quantity less than 10:\n\n";
    while ($row = $result->fetch_assoc()) {
        $message .= "Product: " . $row['p_name'] . " - Stock: " . $row['p_stocksQuantity'] . "\n";
    }

    // Headers
    $headers = "From: orozmush@yourwebsite.com"; // Set the sender email
    $to = $admin_email;
    $subject = 'Stock Alert';
    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email!";
    }
} else {
    echo "No products with stock less than 10.";
}

// Close the connection
$conn->close();
?>
