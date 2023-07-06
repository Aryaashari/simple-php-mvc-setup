<?php

namespace Ewallet\Service;

use Ewallet\Config\Database;
use Ewallet\Exception\ValidationException;
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


    public function isValidToken(string $username, string $token, string $type) : bool {

        try {
            Database::startTransaction();
            $response = $this->emailVerificationRepo->findByToken($token, $type);
            if ($response != null) {

                if ($response->username == $username) {
    
                    if (strtotime($response->expire_time) >= time()) {

                        // Ubah email verification status di user
                        $this->userRepo->updateEmailVerification($username);
                        
                        // Delete token email verification dari user
                        $this->emailVerificationRepo->update($token);
                        
                        Database::commitTransaction();
                        return true;    

                    } else {
                        throw new ValidationException("Token was expired!");
                    }

                } else {
                    throw new ValidationException("Username invalid!");
                }

            }   

            Database::rollbackTransaction();
            throw new ValidationException("Token invalid!");
        } catch(\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }

    }


}