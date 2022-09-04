<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Helper\FlashMessage;

class AuthController {


    public function registerView() : void {
        View::render('/../view/auth/register.php');
    }

    public function register() : void {
        echo "OK";
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