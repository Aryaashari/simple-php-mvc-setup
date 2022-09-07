<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\FlashMessage;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use Ewallet\Service\AuthService;

class AuthController {

    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new WalletRepository, new EmailVerificationRepository, new UserRepository);
    }

    public function registerView() : void {
        View::render('/../view/auth/register.php');
    }

    public function register() : void {
        $name = htmlspecialchars(trim($_POST["name"] ?? ""));
        $email = htmlspecialchars(trim($_POST["email"] ?? ""));
        $username = htmlspecialchars(trim($_POST["username"] ?? ""));
        $password = htmlspecialchars(trim($_POST["password"] ?? ""));
        $confirmPassword = htmlspecialchars(trim($_POST["confirmPassword"] ?? ""));
        $pin = htmlspecialchars(trim($_POST["pin"] ?? ""));

        try {
            $request = new RegisterRequest($name, $email, $username, $password, $confirmPassword, $pin);

            $response = $this->authService->register($request);

            FlashMessage::Send('success', "Success to register, please confirmation your email address ($response)");
            View::redirect("/users/login");
        } catch(ValidationException $e) {
            FlashMessage::Send('error', $e->getMessage());
            View::redirect('/users/register');
        } catch(\Exception $e) {
            var_dump("Error 500");
            exit();
        }

    }

    public function emailVerification() : void {
        var_dump($_GET["user_id"]);
        var_dump($_GET["token"]);
    }

    public function loginView() : void {
        View::render('/../view/auth/login.php');
    }

    public function changePasswordView() : void {
        View::render('/../view/auth/change-password.php');
    }

    public function forgotPasswordView() : void {
        View::render('/../view/auth/forgot-password.php');
    }

    public function resetPasswordView() : void {
        View::render('/../view/auth/reset-password.php');
    }

}