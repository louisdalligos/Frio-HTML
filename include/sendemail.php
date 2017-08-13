<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['wp-contact-form-name'] != '' AND $_POST['wp-contact-form-email'] != '' AND $_POST['wp-contact-form-message'] != '' ) {

        $name = $_POST['wp-contact-form-name'];
        $email = $_POST['wp-contact-form-email'];
        $phone = $_POST['wp-contact-form-phone'];
        $subject = $_POST['wp-contact-form-subject'];
        $message = $_POST['wp-contact-form-message'];

        $subject = isset($subject) ? $subject : 'New Message From Contact Form';

        $botcheck = $_POST['wp-contact-form-botcheck'];

        $toemail = 'hello@wepro.co'; // Your Email Address
        $toname = 'We Pro'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Name: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Phone: $phone<br><br>" : '';
            $message = isset($message) ? "Message: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                echo 'We have <strong>successfully</strong> received your message and will get back to you as soon as possible.';
            else:
                echo 'Email <strong>could not</strong> be sent due to some unexpected error. Please try again later.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
                //echo 'Not sent: <pre>'.print_r(error_get_last(), true).'</pre>';
            endif;
        } else {
            echo 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
        }
    } else {
        echo 'Please <strong>Fill up</strong> all the Fields and Try Again.';
    }
} else {
    echo 'An <strong>unexpected error</strong> occured. Please Try Again later.';
}

?>