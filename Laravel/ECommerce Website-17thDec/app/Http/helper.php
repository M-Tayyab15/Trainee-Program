<?php

// app/Http/helpers.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('sendEmail')) {
    /**
     * Function to send an email via SMTP using PHPMailer
     * 
     * @param array $params The email parameters
     * 
     * @return void
     */
    function sendEmail($params)
    {
        if (empty($params['recipient']['email'])) {
            session()->flash('message', 'Email could not be sent due to no recipient email.');
            return;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $params['sender']['email'];
            $mail->Password   = $params['sender']['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($params['sender']['email'], $params['sender']['name']);
            $mail->addAddress($params['recipient']['email'], $params['recipient']['name']);

            if (!empty($params['cc'])) {
                foreach ($params['cc'] as $cc) {
                    $mail->addCC($cc['email'], $cc['name']);
                }
            }
            if (!empty($params['bcc'])) {
                foreach ($params['bcc'] as $bcc) {
                    $mail->addBCC($bcc['email'], $bcc['name']);
                }
            }

            $mail->isHTML(true);
            $mail->Subject = $params['subject'];
            $mail->Body    = $params['body'];

            $mail->send();
            session()->flash('message', 'Email has been sent successfully');
        } catch (Exception $e) {
            session()->flash('message', "Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
