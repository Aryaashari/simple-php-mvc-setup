<?php

namespace Emoney\Controller;

use Ewallet\App\View;

class HomeController {

    public function index() {
        View::render("home.php");
    }

}