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
Route::get("/users/email/verification", AuthController::class, "emailVerification", []);
Route::post("/users/logout", AuthController::class, "logout", [MustLoginMiddleware::class]);

// User
Route::get('/users/profile', UserController::class, "profile", [MustLoginMiddleware::class]);
Route::post('/users/profile', UserController::class, "editProfile", [MustLoginMiddleware::class]);

Route::get("/password/change", UserController::class, "changePasswordView", [MustLoginMiddleware::class]);
Route::post("/password/change", UserController::class, "changePassword", [MustLoginMiddleware::class]);

Route::get("/password/forgot", UserController::class, "forgotPasswordView", []);
Route::post("/password/forgot", UserController::class, "forgotPassword", []);
Route::get("/users/password/reset/email/verification", AuthController::class, "emailVerification", []);

Route::get("/password/reset", UserController::class, "resetPasswordView", []);


// Wallet
Route::get('/users/wallet/pin/change', WalletController::class, "changePinView", [MustLoginMiddleware::class]);
Route::post('/users/wallet/pin/change', WalletController::class, "changePin", [MustLoginMiddleware::class]);

Route::post('/users/wallet/topup', WalletController::class, "topup", [MustLoginMiddleware::class]);

Route::post('/users/wallet/transfer', WalletController::class, "transfer", [MustLoginMiddleware::class]);


Route::run();