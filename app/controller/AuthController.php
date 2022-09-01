<?php

namespace Ewallet\Controller;

use Ewallet\App\View;

class AuthController {


    public function registerView() : void {
        View::render('/../view/auth/register.php');
    }


    public function loginView() : void {
        View::render('/../view/auth/login.php');
    }

}