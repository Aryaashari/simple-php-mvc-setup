<?php

namespace Ewallet\Service;

use Ewallet\Domain\Session;
use Ewallet\Model\Session\CreateSessionRequest;
use Ewallet\Model\Session\CreateSessionResponse;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;

class SessionService {

    private SessionRepository $sessionRepo;
    private UserRepository $userRepo;

    public function __construct(SessionRepository $sessionRepo, UserRepository $userRepo)
    {
        $this->sessionRepo = $sessionRepo;
        $this->userRepo = $userRepo;
    }

    public function getSessionById(int $sessionId) : ?Session {
        try {
            $session = $this->sessionRepo->findById($sessionId);
            if ($session !== null) {
                return $session;
            }
            return null;
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function createSession(CreateSessionRequest $request) : CreateSessionResponse {
        try {
            $session = $this->sessionRepo->create($request->username, $request->ipAddress, $request->userAgent);
            return new CreateSessionResponse($session->id);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function updateLastActivatedTime(int $sessionId) : void {
        try {
            $session = $this->sessionRepo->findById($sessionId);
            if ($session != null) {
                $timeNow = time();
                $session->last_activated_at = date("Y-m-d H:i:s", $timeNow);
                $session->expire_time = date("Y-m-d H:i:s", $timeNow + 120);
                $this->sessionRepo->update($session);
                return;
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteSession(int $sessionId) : void {
        try {
            $this->sessionRepo->delete($sessionId);
            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function isValidSession(int $sessionId) : bool {
        try {
            $session = $this->getSessionById($sessionId);
            return $session !== null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function isNotExpiredSession(int $sessionId) : bool {
        try {
            $session = $this->getSessionById($sessionId);
            return ($session !== null) && (strtotime($session->expire_time) >= time());
        } catch (\Exception $e) {
            throw $e;
        }
    }

}