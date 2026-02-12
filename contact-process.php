<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

include_once "C:\laragon\www\SLAM\Account\config\dotenv.php";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if(!empty($_POST["first-name"]) 
&& !empty($_POST["last-name"]) 
&& !empty($_POST["email"])
&& !empty($_POST["subject"]) 
&& !empty($_POST["message"])) {
    if (isset($_POST["agree-to-policies"])) {

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $_ENV["SERVER_MAIL"];              //SMTP username
            $mail->Password   = $_ENV["SERVER_PASSWORD"];                  //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($_POST["email"], $_POST["first-name"]." ".$_POST["last-name"]);
            $mail->addAddress($_ENV["SERVER_MAIL"]);     //Add a recipient
           
            $mail->Subject = $_POST["subject"];
            $mail->Body    = $_POST["message"];
        
            $mail->send();
            
            $info = "sucess";
            header("Location: contact.php?info=$info");
            exit;

        
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        $info = "not-agreed";
        header("Location: contact.php?info=$info");
        exit;
    }

} else {
    $info = "empty";
    header("Location: contact.php?info=$info");
    exit;

}

