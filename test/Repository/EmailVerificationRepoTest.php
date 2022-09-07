<?php

namespace Ewallet\Repository;

use Ewallet\Domain\User;
use PHPUnit\Framework\TestCase;

class EmailVerificationRepoTest extends TestCase {


    private EmailVerificationRepository $emailVerificationRepo;
    private UserRepository $userRepo;

    public function setUp() :void {
        $this->emailVerificationRepo = new EmailVerificationRepository;
        $this->userRepo = new UserRepository;
        $this->emailVerificationRepo->deleteAll();
        $this->userRepo->deleteAll();
    }


    public function testCreate() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $token = $this->emailVerificationRepo->create($user->id);
        var_dump($token);
        $this->assertIsString($token);
    }

    public function testFindByUserId() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $token = $this->emailVerificationRepo->create($user->id);
        var_dump($token);

        $token2 = $this->emailVerificationRepo->findByUserId($user->id);
        var_dump($token2);

        $this->assertIsString($token2);
        $this->assertEquals($token, $token2);
    }


    public function testDeleteByUserId() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $token = $this->emailVerificationRepo->create($user->id);
        var_dump($token);

        $this->emailVerificationRepo->deleteByUserId($user->id);

        $token2 = $this->emailVerificationRepo->findByUserId($user->id);
        var_dump($token2);

        $this->assertNull($token2);
    }
    


}