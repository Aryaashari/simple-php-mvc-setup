<?php

namespace Ewallet\Mail;

use Ewallet\Config\Mail as ConfigMail;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Mail {

    private PHPMailer $mail;

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


    public function view(string $path, array $data) : void {
        $this->mail->msgHTML(file_get_contents(__DIR__."/../view/".$path));
    }

    public function send(string $subject) : bool {
        $this->mail->Subject = $subject;
        $this->mail->setFrom($this->from["address"], $this->from["name"]);

        foreach($this->recipients as $address => $name) {
            $this->mail->addCC($address, $name);
        }

        return true;
    }


}