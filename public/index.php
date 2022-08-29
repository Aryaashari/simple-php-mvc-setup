<?php

require_once __DIR__."/../vendor/autoload.php";

use Emoney\App\Route;
use Emoney\Controller\HomeController;

Route::get("/", HomeController::class, "index", []);
Route::run();