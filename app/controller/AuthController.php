<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Config\App;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\FlashMessage;
use Ewallet\Model\Auth\LoginRequest;
use Ewallet\Model\Auth\LogoutRequest;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use Ewallet\Service\AuthService;
use Ewallet\Service\EmailVerificationService;
use Ewallet\Service\SessionService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
            var_dump($e);
            exit();
        }

    }

    public function emailVerification() : void {
        $username = htmlspecialchars(trim($_GET["username"] ?? ""));
        $token = htmlspecialchars(trim($_GET["token"] ?? ""));
        $type = htmlspecialchars(trim($_GET["type"] ?? ""));

        try {
            if ($username != "" && $token != "") {
                $response = $this->emailVerificationService->isValidToken($username, $token, $type);
    
                if ($response == true) {
                    if ($type == "register") {
                        FlashMessage::Send('success', 'Success verification email!');
                        View::redirect("/users/login");
                    } else {
                        View::redirect("/password/reset");
                    }
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
            View::redirect("/");
            FlashMessage::Send("success", "Login Successfully");
        } catch (ValidationException $e) {
            FlashMessage::Send("error", $e->getMessage());
            View::redirect("/users/login");
        } catch (\Exception $e) {
            var_dump("Server Error");
            var_dump($e);
            exit();
        }
    }

    public function logout() : void {
        try {
            $jwt = $_COOKIE["APP_AUTH_SESSION"];
            $decode = JWT::decode($jwt, new Key(App::$appKey, 'HS256'));
            $logoutReq = new LogoutRequest($decode->session_id);
            $this->authService->logout($logoutReq);

            FlashMessage::Send('success', 'Logout Successfully');
            View::redirect("/login");
        } catch (\Exception) {
            var_dump("Server Error");
            exit();
        }
    }

}