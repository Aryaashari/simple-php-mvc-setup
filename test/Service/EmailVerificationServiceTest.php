<?php

namespace Ewallet\Service;

use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Domain\User;
use PHPUnit\Framework\TestCase;

class EmailVerificationServiceTest extends TestCase {


    private EmailVerificationService $emailVerificationService;
    private EmailVerificationRepository $emailVerificationRepo;
    private UserRepository $userRepo;

    public function setUp() : void {
        $this->emailVerificationRepo = new EmailVerificationRepository;
        $this->userRepo = new UserRepository;
        $this->emailVerificationService = new EmailVerificationService($this->emailVerificationRepo, $this->userRepo);
        $this->emailVerificationRepo->deleteAll();
        $this->userRepo->deleteAll();
    }



    public function testIsValidToken() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $token = $this->emailVerificationRepo->create($user->id);

        $isValid = $this->emailVerificationService->isValidToken($user->id, $token);
        $this->assertTrue($isValid);
    }

    public function testIsValidTokenFalse() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $token = $this->emailVerificationRepo->create($user->id);
        $isValid = $this->emailVerificationService->isValidToken($user->id, "");
        $this->assertFalse($isValid);
    }


}