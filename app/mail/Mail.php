<?php

namespace Ewallet\Mail;

use Ewallet\Config\Mail as ConfigMail;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Mail {

    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = ConfigMail::getMailer();
    }

    public array $recipients  = [];
    public array $from = [
        "address" => "",
        "name" => ""
    ];
    public bool $isHtmlView = true;


    public function view(string $path, array $data = []) : void {
    }

    public function build(string $subject) : bool|string {
        $this->mail->Subject = $subject;
        $this->mail->setFrom($this->from["address"], $this->from["name"]);

        foreach($this->recipients as $address => $name) {
            $this->mail->addAddress($address, $name);
        }
        
        if ($this->mail->send()) {
            return true;
        } else {
            return $this->mail->ErrorInfo;
        }
    }


}