<?php

namespace Ewallet\Service;

use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\UserRepository;

class EmailVerificationService {


    private EmailVerificationRepository $emailVerificationRepo;
    private UserRepository $userRepo;

    public function __construct(EmailVerificationRepository $emailVerificationRepo, UserRepository $userRepo)
    {
        $this->emailVerificationRepo = $emailVerificationRepo;
        $this->userRepo = $userRepo;
    }


    public function isValidToken(int $userId, string $token) : bool {

        try {
            $tokenUser = $this->emailVerificationRepo->findByUserId($userId);
            if (!is_null($tokenUser)) {
                if ($tokenUser === $token) {
                    // Ubah email verification status di user
                    $this->userRepo->updateEmailVerification($userId);
                    
                    // Delete token email verification dari user
                    $this->emailVerificationRepo->deleteByUserId($userId);

                    return true;
                }
            }

            return false;
        } catch(\Exception $e) {
            throw $e;
        }

    }


}