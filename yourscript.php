<?php
$i = $i !== null ? $i : 1;

$to = 'sumanmuahya@gmail.com'; // Replace with the recipient's email address
$subject = 'Test Email';
$message = 'This is a test email sent from PHP  !'.$i;
$headers = 'From: orozmush@gmail.com'; // Replace with the sender's email address


// Send email
if (mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully.';
    
} else {
    echo 'Failed to send email.';
}
?>
