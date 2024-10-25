<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendMail($email, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ryniellapira957@gmail.com';
        $mail->Password = 'jogt wshv olrd pzto';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('ryniellapira957@gmail.com', 'SANTA RITA RECORD SYSTEM');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();
        return "success";
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<?php
$response = '';
if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $response = "All fields are required";
    } else {
        $response = sendMail($_POST['email'], $_POST['subject'], $_POST['message']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .email-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .email-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }
        .email-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444;
        }
        .email-form input, .email-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border 0.3s ease;
        }
        .email-form input:focus, .email-form textarea:focus {
            border-color: #ff416c; /* Change focus border color */
            outline: none;
        }
        .email-form button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .email-form button:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.03);
        }
        .notification {
            text-align: center;
            margin-top: 10px;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .notification.show {
            opacity: 1;
            display: block;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .back-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6a5acd, #8360c3);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #8360c3, #6a5acd);
        }
        @media (max-width: 600px) {
            .email-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="email-form">
        <h2>Send Email Notification</h2>
        <form action="" method="post">
            <label for="email">Recipient Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter recipient email" required>
            
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter email subject" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" placeholder="Enter your message" required></textarea>
            
            <button type="submit" name="submit">Send Email</button>
            <button type="button" class="back-btn" onclick="window.location.href='index.php'">BACK</button>

            <?php if (isset($response)) : ?>
                <div class="notification <?= $response == 'success' ? 'success show' : 'error show'; ?>">
                    <?= $response == 'success' ? 'Email sent successfully.' : $response; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
