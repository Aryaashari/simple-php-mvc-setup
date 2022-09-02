<?php

require_once __DIR__."/../vendor/autoload.php";

use Ewallet\App\Route;
use Ewallet\Controller\HomeController;
use Ewallet\Controller\AuthController;
use Ewallet\Controller\UserController;
use Ewallet\Controller\WalletController;

Route::get("/", HomeController::class, "index", []);

// Auth
Route::get("/users/register", AuthController::class, "registerView", []);
Route::get("/users/login", AuthController::class, "loginView", []);
Route::get("/password/change", AuthController::class, "changePasswordView", []);
Route::get("/password/forgot", AuthController::class, "forgotPasswordView", []);
Route::get("/password/reset", AuthController::class, "resetPasswordView", []);

// User
Route::get('/users/profile', UserController::class, "profile", []);

// Wallet
Route::get('/users/wallet/pin/change', WalletController::class, "changePinView", []);


Route::run();