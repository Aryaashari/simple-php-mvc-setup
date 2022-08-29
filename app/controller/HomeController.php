<?php

namespace Emoney\Controller;

use Emoney\App\View;

class HomeController {

    public function index() {
        View::render("home.php");
    }

}