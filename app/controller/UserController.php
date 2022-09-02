<?php

namespace Ewallet\Controller;

use Ewallet\App\View;

class UserController {

    public function profile() {
        View::render('/../view/user/profile.php');
    }


}