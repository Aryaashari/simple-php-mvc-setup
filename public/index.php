<?php

require_once __DIR__."/../vendor/autoload.php";

use Ewallet\App\Route;
use Ewallet\Config\Database;
use Ewallet\Config\Mail;
use Ewallet\Controller\HomeController;
use Ewallet\Controller\AuthController;
use Ewallet\Controller\UserController;
use Ewallet\Controller\WalletController;
use Ewallet\Helper\FlashMessage;
use Ewallet\Middleware\MustLoginMiddleware;
use Ewallet\Middleware\MustNotLoginMiddleware;

Database::getConnection("mysql", "production");
Mail::getMailer("production");

Route::get("/", HomeController::class, "index", [MustLoginMiddleware::class]);

// Auth
Route::get("/users/register", AuthController::class, "registerView", [MustNotLoginMiddleware::class]);
Route::post("/users/register", AuthController::class, "register", [MustNotLoginMiddleware::class]);
Route::get("/users/login", AuthController::class, "loginView", [MustNotLoginMiddleware::class]);
Route::post("/users/login", AuthController::class, "login", [MustNotLoginMiddleware::class]);
Route::get("/password/change", AuthController::class, "changePasswordView", []);
Route::get("/password/forgot", AuthController::class, "forgotPasswordView", []);
Route::get("/password/reset", AuthController::class, "resetPasswordView", []);
Route::get("/users/email/verification", AuthController::class, "emailVerification", []);
Route::post("/users/logout", AuthController::class, "logout", [MustLoginMiddleware::class]);

// User
Route::get('/users/profile', UserController::class, "profile", []);

// Wallet
Route::get('/users/wallet/pin/change', WalletController::class, "changePinView", []);


Route::run();