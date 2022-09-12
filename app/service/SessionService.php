<?php

namespace Ewallet\Service;

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

}