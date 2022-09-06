<?php

namespace Ewallet\Mail;

use DOMDocument;

class VerificationMail extends Mail {


    public function view(string $path, array $data = []): void
    {
        if($this->isHtmlView) {
            $dom = new DOMDocument();
            $dom->loadHTMLFile(__DIR__."/../view/".$path);
            $btnVerify = $dom->getElementById("btnEmailVerify");
            $btnVerify->setAttribute("href", $data["link"]);
            $this->mail->msgHTML($dom->saveHTML());
        }
    }

}