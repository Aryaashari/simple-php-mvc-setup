<?php

require_once __DIR__."/../vendor/autoload.php";

use Ewallet\App\Route;
use Ewallet\Controller\HomeController;

Route::get("/", HomeController::class, "index", []);
Route::run();