<?php

namespace Ewallet\Middleware;

use DomainException;
use Ewallet\App\View;
use Ewallet\Config\App;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\FlashMessage;
use Ewallet\Middleware\Middleware;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Service\SessionService;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class MustLoginMiddleware implements Middleware {

    private SessionService $sesService;

    public function __construct()
    {
        $this->sesService = new SessionService(new SessionRepository, new UserRepository);
    }


    function boot(): void
    {
        try {
            if (isset($_COOKIE["APP_AUTH_SESSION"])) {
                $jwt = $_COOKIE["APP_AUTH_SESSION"];
                $decoded = JWT::decode($jwt, new Key(App::$appKey, "HS256"));
                // Is valid session 
                if (!$this->sesService->isValidSession($decoded->session_id)) {
                    throw new ValidationException();
                }

                $session = $this->sesService->getSessionById($decoded->session_id);

                // Check expired time
                if (!$this->sesService->isNotExpiredSession($session->id)) {
                    throw new ValidationException();
                }

                $this->sesService->updateLastActivatedTime($session->id);
            } else {
                FlashMessage::Send("error", "You must login");
                View::redirect("/users/login");    
            }
        } catch(ValidationException | DomainException) {
            // Logout
            FlashMessage::Send("error", "Session Expired");
            View::redirect("/users/login");
        } catch(Exception) {
            var_dump(500);
        }

    }

}