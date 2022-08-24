<?php

namespace Simple\Php\Mvc\Controller;

use Simple\Php\Mvc\App\View;

class HomeController {

    public function index() {
        View::render("home.php");
    }

}