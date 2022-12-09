<?php

namespace Ewallet\Helper;

use Ewallet\App\View;
use Ewallet\Config\App;
use Ewallet\Domain\User;
use Ewallet\Repository\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth {

    // public static UserRepository $userRepo = new UserRepository();

    // public function __construct()
    // {
    //     self::$userRepo = new UserRepository();
    // }

    public static function User() : User {
        
        try {
            $jwt = $_COOKIE["APP_AUTH_SESSION"];
            $decoded = JWT::decode($jwt, new Key(App::$appKey, "HS256"));
            $userRepo = new UserRepository();
            $user = $userRepo->findByUsername($decoded->username);
            return $user;
        } catch (\DomainException $e) {
            FlashMessage::Send("error", "Session Expired");
            View::redirect("/users/login");
        } catch (\Exception) {
            var_dump("500 SERVER ERROR");
            exit();
        }
    }

}