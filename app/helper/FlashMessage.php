<?php

namespace Ewallet\Helper;

class FlashMessage {
    

    public static function Send(string $type = 'success', string $message) : void {
        if($type == 'success') {
            setcookie('FLASH_MESSAGE_SUCCESS', $message, 0, "/");
        } else if ($type == 'error') {
            setcookie('FLASH_MESSAGE_ERROR', $message, 0, "/");
        }
    }

    private static function Clear() : void {
        if (isset($_COOKIE["FLASH_MESSAGE_SUCCESS"])) {
            unset($_COOKIE["FLASH_MESSAGE_SUCCESS"]);
            setcookie("FLASH_MESSAGE_SUCCESS", null, -100, "/");
        } else if (isset($_COOKIE["FLASH_MESSAGE_ERROR"])) {
            unset($_COOKIE["FLASH_MESSAGE_ERROR"]);
            setcookie("FLASH_MESSAGE_ERROR", null, -100, "/");
        }
    }


    public static function GetMessage() : string {
        $message = '';
        if (isset($_COOKIE["FLASH_MESSAGE_SUCCESS"])) {
            $message = $_COOKIE["FLASH_MESSAGE_SUCCESS"];
        } else if (isset($_COOKIE["FLASH_MESSAGE_ERROR"])) {
            $message = $_COOKIE["FLASH_MESSAGE_ERROR"];
        }
        FlashMessage::Clear();
        return $message;
    }



}