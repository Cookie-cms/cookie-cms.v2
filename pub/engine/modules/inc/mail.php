<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require __RDS__ . '/vendor/autoload.php';

function sendMail($to, $subject, $message, $fromEmail, $fromName) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
    $Config = $yaml_data['smtp'];

    $mail = new PHPMailer(true); // Passing `true` enables exceptions
    
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $Config['host'];
        $mail->SMTPAuth   = $Config['SMTPAuth'];
        $mail->Username   = $Config['Username'];
        $mail->Password   = $Config['Password'];
        $mail->SMTPSecure = $Config['SMTPSecure'];
        $mail->Port       = $Config['port'];

        //Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
}

// Example usage:
// $recipient = 'recipient@example.com';
// $subject = 'Test Email';
// $message = 'This is a test email sent using PHPMailer.';
// $fromEmail = 'your-email@example.com';
// $fromName = 'Your Name';

// sendMail($recipient, $subject, $message, $fromEmail, $fromName);
?>
