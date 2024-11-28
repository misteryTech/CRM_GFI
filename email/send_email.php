<?php
// Include Composer's autoloader
require 'vendor/autoload.php';

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $recipient_email = $_POST['recipient_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                      // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                         // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                // Enable SMTP authentication
        $mail->Username = 'your_email@gmail.com';              // SMTP username (your Gmail address)
        $mail->Password = 'your_email_password';               // SMTP password (use app password if you have 2FA enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    // Enable TLS encryption
        $mail->Port = 587;                                    // TCP port to connect to (587 for TLS)

        // Recipients
        $mail->setFrom('your_email@gmail.com', 'Your Name');   // Sender's email and name
        $mail->addAddress($recipient_email);  // Add recipient's email

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;      // Use the subject from the form
        $mail->Body    = $message;     // Use the message from the form
        $mail->AltBody = strip_tags($message);  // Plain text version of the message

        // Send the email
        if ($mail->send()) {
            echo 'Message has been sent successfully!';
        } else {
            echo 'Message could not be sent.';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
