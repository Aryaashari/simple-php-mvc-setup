<?php

namespace Ewallet\Helper;

use Ewallet\App\View;
use Ewallet\Config\App;
use Ewallet\Domain\User;
use Ewallet\Repository\UserRepository;
use Firebase\JWT\JWT;

class Auth {

    public static UserRepository $userRepo;

    public function __construct()
    {
        self::$userRepo = new UserRepository();
    }

    public static function User() : User {
        
        try {

            $jwt = $_SESSION["APP_AUTH_SESSION"];
            $decoded = JWT::decode($jwt, App::$appKey);
    
            $user = self::$userRepo->findByUsername($decoded["username"]);
            return $user;
        } catch (\DomainException $e) {
            FlashMessage::Send("error", "Session Expired");
            View::redirect("/users/login");
        } catch (\Exception) {
            var_dump("500 SERVER ERROR");
        }
    }

}