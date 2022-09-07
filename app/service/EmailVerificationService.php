<?php

namespace Ewallet\Service;

use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\UserRepository;

class EmailVerificationService {


    private EmailVerificationRepository $emailVerificationRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->emailVerificationRepo = new EmailVerificationRepository;
        $this->userRepo = new UserRepository;
    }


    // public function isValidToken(int $userId, string $token) : bool {

    // }


}