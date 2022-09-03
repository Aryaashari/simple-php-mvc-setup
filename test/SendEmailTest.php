<?php

namespace Ewallet;

use PHPUnit\Framework\TestCase;
use PHPMailer\PHPMailer\PHPMailer;

class SendEmailTest extends TestCase {


    public function testSendWithPhpMailer() : void {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        // $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Port = 2525;
        $phpmailer->Username = '466793276331f1';
        $phpmailer->Password = '95f06b6c802656';
        $phpmailer->Subject = "Tes";
        // $phpmailer->Body = "Tes";
        $phpmailer->setFrom('aryaashari100@gmail.com', 'Arya Ashari');
        $phpmailer->addAddress('aryaashari200@email.com', 'Receiver Name');
        $phpmailer->isHTML(true);
        $phpmailer->msgHTML(file_get_contents(__DIR__.'/../app/view/mail/tes.html'), __DIR__);
        if ($phpmailer->Send()) {
            echo "OK";
        } else {
            echo $phpmailer->ErrorInfo;
            // echo "Error";
        }
        $this->assertNotNull($phpmailer);
    }

    public function testSendWithMailFunction() : void {
        ini_set('SMTP', 'smtp.mailtrap.io');
        ini_set('smtp_port', 25);
        $to = "aryaashari100@gmail.com";
        $subject = "My subject";
        $txt = "Hello world!";
        $headers = "From: aryaashari200@gmail.com";

        mail($to,$subject,$txt,$headers);
        $this->assertTrue(true);
    }


}