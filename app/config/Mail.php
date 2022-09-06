<?php

namespace Ewallet\Config;

use PHPMailer\PHPMailer\PHPMailer;

class Mail {

    private static ?PHPMailer $phpMailer = null;

    public static function getMailer(string $env = "test") : PHPMailer {

        if (self::$phpMailer == null) {

            self::$phpMailer = new PHPMailer();
            if ($env == "test") {
                self::$phpMailer->isSMTP();
                self::$phpMailer->Host = 'smtp.mailtrap.io';
                self::$phpMailer->SMTPAuth = true;
                self::$phpMailer->Port = 2525;
                self::$phpMailer->Username = '466793276331f1';
                self::$phpMailer->Password = '95f06b6c802656';
            } else if ($env == "production") {
                self::$phpMailer->isSMTP();
                self::$phpMailer->Host = 'smtp.mailtrap.io';
                self::$phpMailer->SMTPAuth = true;
                self::$phpMailer->Port = 2525;
                self::$phpMailer->Username = '466793276331f1';
                self::$phpMailer->Password = '95f06b6c802656';
            }
        }

        return self::$phpMailer;

    }

}