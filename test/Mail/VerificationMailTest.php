<?php

namespace Ewallet\Mail;

use PHPUnit\Framework\TestCase;

class VerificationMailTest extends TestCase {

    private VerificationMail $mail;

    public function setUp() : void {
        $this->mail = new VerificationMail;
    }


    public function testSendMail() : void {
        $this->mail->recipients = [
            "aryaashari200@gmail.com" => "Arya Ashari"
        ];

        $this->mail->from["address"] = "aryaashari100@gmail.com";
        $this->mail->from["name"] = "Arya Ashari";

        $this->mail->view('mail/verification.html', ["link" => "https://www.youtube.com"]);
        $mailer = $this->mail->build("Verification Email");
        var_dump($mailer);
        $this->assertTrue($mailer);
    }

    public function testViewMail() {
        $html = $this->mail->view("mail/verification.html");
        $this->assertTrue(true);
    }

}