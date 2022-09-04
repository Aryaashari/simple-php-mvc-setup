<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Helper\FlashMessage;
use Ewallet\Model\Auth\RegisterRequest;

class AuthController {

    public function registerView() : void {
        View::render('/../view/auth/register.php');
    }

    public function register() : void {
        $name = htmlspecialchars(trim($_POST["name"] ?? ""));
        $email = htmlspecialchars(trim($_POST["email"] ?? ""));
        $username = htmlspecialchars(trim($_POST["username"] ?? ""));
        $password = htmlspecialchars(trim($_POST["password"] ?? ""));
        $confirmPassword = htmlspecialchars(trim($_POST["confirmPassword"] ?? ""));
        $pin = htmlspecialchars(trim($_POST["pin"] ?? ""));

        $request = new RegisterRequest($name, $email, $username, $password, $confirmPassword, $pin);

    }


    public function loginView() : void {
        View::render('/../view/auth/login.php');
    }

    public function changePasswordView() : void {
        View::render('/../view/auth/change-password.php');
    }

    public function forgotPasswordView() : void {
        View::render('/../view/auth/forgot-password.php');
    }

    public function resetPasswordView() : void {
        View::render('/../view/auth/reset-password.php');
    }

}