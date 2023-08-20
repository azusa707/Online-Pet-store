<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['g-name'];
    $email = $_POST['g-email'];
    $message = $_POST['g-msg'];

    // Compose the email body
    $email_body = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";

    // Send the email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to SMTP::DEBUG_SERVER for more detailed logs
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server (e.g., smtp.sendgrid.net for SendGrid)
        $mail->SMTPAuth = true;
        $mail->Username = 'bca210625_nalina@achsnepal.edu.np'; // Replace with your Gmail or SMTP username
        $mail->Password = '9803119218'; // Replace with your Gmail or SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to; use 465 for `PHPMailer::ENCRYPTION_SMTPS` (e.g., for Gmail)

        // Recipients
        $mail->setFrom('bca210625_nalina@achsnepal.edu.np', 'Your Name'); // Replace with your "from" email and name
        $mail->addAddress('bca210626_azusa@achsnepal.edu.np', 'Recipient Name'); // Replace with the recipient's email and name

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = $email_body;

        // Send the email
        $mail->send();
        echo 'Thank you for your message. We will get in touch soon!';
    } catch (Exception $e) {
        echo 'Oops! Something went wrong. Please try again later.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>