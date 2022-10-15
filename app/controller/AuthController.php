<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\FlashMessage;
use Ewallet\Model\Auth\LoginRequest;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use Ewallet\Service\AuthService;
use Ewallet\Service\EmailVerificationService;
use Ewallet\Service\SessionService;

class AuthController {

    private AuthService $authService;
    private EmailVerificationService $emailVerificationService;

    public function __construct()
    {
        $userRepo = new UserRepository;
        $this->authService = new AuthService(new WalletRepository, new EmailVerificationRepository, $userRepo, new SessionService(new SessionRepository, $userRepo));
        $this->emailVerificationService = new EmailVerificationService(new EmailVerificationRepository, $userRepo);
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
        $userId = htmlspecialchars(trim($_GET["user_id"] ?? ""));
        $token = htmlspecialchars(trim($_GET["token"] ?? ""));

        try {
            if ($userId != "" && $token != "") {
                $response = $this->emailVerificationService->isValidToken($userId, $token);
    
                if ($response == true) {
                    FlashMessage::Send('success', 'Success verification email!');
                    View::redirect("/users/login");
                }
            }
    
            FlashMessage::Send('error', 'Invalid token or user id!');
            View::redirect("/users/login");
        } catch(\Exception $e) {
            var_dump($e);
            exit();
        }

    }

    public function loginView() : void {
        View::render('/../view/auth/login.php');
    }

    public function login() : void {
        $username = htmlspecialchars(trim($_POST["username"] ?? ""));
        $password = htmlspecialchars(trim($_POST["password"] ?? ""));
        $request = new LoginRequest($username, $password);

        try {
            $response = $this->authService->login($request);
            setcookie("APP_AUTH_SESSION", $response->jwt, 0, "/");
            FlashMessage::Send("success", "Login Successfully");
            View::redirect("/");
        } catch (ValidationException $e) {
            FlashMessage::Send("error", $e->getMessage());
            View::redirect("/users/login");
        } catch (\Exception $e) {
            var_dump("Server Error");
            exit();
        }
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