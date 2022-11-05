<?php

namespace Ewallet\Middleware;

use DomainException;
use Ewallet\App\View;
use Ewallet\Config\App;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\FlashMessage;
use Ewallet\Middleware\Middleware;
use Ewallet\Model\Auth\LogoutRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use Ewallet\Service\AuthService;
use Ewallet\Service\SessionService;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class MustNotLoginMiddleware implements Middleware {

    private SessionService $sesService;
    private AuthService $authService;

    public function __construct()
    {
        $this->sesService = new SessionService(new SessionRepository, new UserRepository);
        $this->authService = new AuthService(new WalletRepository, new EmailVerificationRepository, new UserRepository, new SessionService(new SessionRepository, new UserRepository));
    }


    function boot(): void
    {
        try {
            if (isset($_COOKIE["APP_AUTH_SESSION"])) {
                $jwt = $_COOKIE["APP_AUTH_SESSION"];
                $decoded = JWT::decode($jwt, new Key(App::$appKey, "HS256"));

                $logoutReq = new LogoutRequest($decoded->session_id);
                
                // Is valid session 
                if (!$this->sesService->isValidSession($decoded->session_id)) {
                    $this->authService->logout($logoutReq);
                    throw new ValidationException();
                }

                $session = $this->sesService->getSessionById($decoded->session_id);

                // Check expired time
                if (!$this->sesService->isNotExpiredSession($session->id)) {
                    $this->authService->logout($logoutReq);
                    throw new ValidationException();
                }

                $this->sesService->updateLastActivatedTime($session->id);

                View::redirect("/");
            }
        } catch(ValidationException | DomainException) {
            FlashMessage::Send("error", "Session Expired");
            unset($_COOKIE["APP_AUTH_SESSION"]);
            setcookie("APP_AUTH_SESSION", null, -1, "/");
            View::redirect("/users/login");
        } catch(Exception) {
            var_dump(500);
        }

    }

}