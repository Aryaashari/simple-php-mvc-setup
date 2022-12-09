<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Helper\Auth;

class HomeController {

    public function index() {
        $user = Auth::User();
        $user = [
            "fullname" => $user->name,
            "photo" => $user->profile_photo
        ];

        View::render("home.php",$user);
    }

}