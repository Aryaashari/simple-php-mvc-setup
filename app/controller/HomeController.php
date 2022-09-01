<?php

namespace Ewallet\Controller;

use Ewallet\App\View;

class HomeController {

    public function index() {
        View::render("home.php");
    }

}