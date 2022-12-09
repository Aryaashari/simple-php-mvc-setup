<?php

namespace Ewallet\Service;

use Ewallet\Config\App;
use Ewallet\Config\Database;
use Ewallet\Domain\User;
use Ewallet\Domain\Wallet;
use Ewallet\Exception\ValidationException;
use Ewallet\Mail\VerificationMail;
use Ewallet\Model\Auth\LoginRequest;
use Ewallet\Model\Auth\LoginResponse;
use Ewallet\Model\Auth\LogoutRequest;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Model\Session\CreateSessionRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use Exception;
use Firebase\JWT\JWT;

class AuthService {

    private UserRepository $userRepo;
    private EmailVerificationRepository $emailVerificationRepo;
    private WalletRepository $walletRepo;
    private SessionService $sessionService;
    public function __construct(WalletRepository $walletRepo, EmailVerificationRepository $emailVerificationRepo, UserRepository $userRepo, SessionService $sessionService)
    {
        $this->walletRepo = $walletRepo;
        $this->userRepo = $userRepo;
        $this->emailVerificationRepo = $emailVerificationRepo;
        $this->sessionService = $sessionService;
    }

    public function register(RegisterRequest $request) : string {

        try {
            // Validasi request
            if($request->name == "") {
                throw new ValidationException("Name is required!");
            } else if (!preg_match_all('/^[a-zA-Z\s]*$/',$request->name)) {
                throw new ValidationException("Name is must alphabet or space!");
            } else if(strlen($request->name) < 3) {
                throw new ValidationException("Name min 3 characters!");
            } else if(strlen($request->name) > 30) {
                throw new ValidationException("Name max 30 characters!");
            }

            
            if($request->email == "") {
                throw new ValidationException("Email is required!");
            } else if(!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $request->email)) {
                throw new ValidationException("Email must be type of email!");
            } else if($this->userRepo->findByEmail($request->email) != null) {
                throw new ValidationException("Email is already exist!");
            }
            
            if($request->username == "") {
                throw new ValidationException("Username is required!");
            } else if(!preg_match_all('/^[a-zA-Z_0-9]*$/', $request->username)) {
                throw new ValidationException("Username must be valid(a-z, A-Z, 0-9, _)!");
            } else if(strlen($request->username) < 3) {
                throw new ValidationException("Username min 3 characters!");
            } else if(strlen($request->username) > 10) {
                throw new ValidationException("Username max 10 characters!");
            } else if($this->userRepo->findByUsername($request->username) != null) {
                throw new ValidationException("Username is already exist!");
            }


            if($request->password == "") {
                throw new ValidationException("Password is required!");
            } else if(strlen($request->password) < 8) {
                throw new ValidationException("Password min 8 characters!");
            }

            if($request->confirmPassword == "") {
                throw new ValidationException("Password confirmation is required!");
            } else if(strlen($request->confirmPassword) < 8) {
                throw new ValidationException("Password confirmation min 8 characters!");
            } else if($request->password !== $request->confirmPassword) {
                throw new ValidationException("Password confirmation is not same with password!");
            }


            if($request->pin == "") {
                throw new ValidationException("PIN Number is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->pin)) {
                throw new ValidationException("PIN Number must be integer!");
            } else if(strlen($request->pin) != 6) {
                throw new ValidationException("PIN Number must be 6 characters!");
            }

            Database::startTransaction();
            // Create Data User
            $user = $this->userRepo->create(new User(null, $request->name, $request->email, $request->username, password_hash($request->password, PASSWORD_BCRYPT), "user.png", false, null));

            // Create wallet for user
            $wallet = $this->walletRepo->create(new Wallet(null,$user->id, 0, $request->pin));

            // Create email verification token
            $token = $this->emailVerificationRepo->create($user->id);

            // Create url for email verification
            $url = App::$baseUrl."/users/email/verification?user_id=$user->id&token=$token";

            // Send verification link to user's email
            $mail = new VerificationMail;
            $mail->recipients = [$user->email => $user->name];
            $mail->from["address"] = "aryaashari100@gmail.com";
            $mail->from["name"] = "Admin";
            $mail->view("mail/verification.html", ["link" => $url]);
            $status = $mail->build("Email Verification");
            if($status != true) {
                throw new Exception($status);
            }

            Database::commitTransaction();
            // Return Response
            return $user->email;
        } catch(\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }

    }

    public function login(LoginRequest $request) : LoginResponse {

        try {
            // Validasi request
            if ($request->username == "") {
                throw new ValidationException("Username is required!");
            }
            
            if ($request->password == "") {
                throw new ValidationException("Password is required!");
            }

            $user = $this->userRepo->findByUsername($request->username);
            if ($user == null || !password_verify($request->password, $user->password)) {
                throw new ValidationException("Username or password invalid!");
            }

            if (!$user->email_verified) {
                throw new ValidationException("Please verify your email address!");
            }

            // Create session
            $ipAddr = $_SERVER["REMOTE_ADDR"];
            $userAgent = $_SERVER["HTTP_USER_AGENT"];
            $session = $this->sessionService->createSession(new CreateSessionRequest($user->id, $ipAddr, $userAgent));

            // Create JWT Token
            $payload = [
                "session_id" => $session->id,
                "username" => $user->username
            ];

            $jwt = JWT::encode($payload, App::$appKey, 'HS256');
            return new LoginResponse($jwt);
        } catch(\Exception $e) {
            throw $e;
        }

    }


    public function logout(LogoutRequest $logoutRequest) : void {
        try {
            $this->sessionService->deleteSession($logoutRequest->sessionId);
            unset($_COOKIE["APP_AUTH_SESSION"]);
            setcookie("APP_AUTH_SESSION", null, -1, "/");
        } catch (\Exception $e) {
            throw $e;
        }
    }


}