<?php

require_once __DIR__."/../vendor/autoload.php";

use Simple\Php\Mvc\App\Route;
use Simple\Php\Mvc\Controller\HomeController;

Route::get("/", HomeController::class, "index", []);
Route::run();