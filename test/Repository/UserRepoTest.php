<?php

namespace Ewallet\Repository;

use Ewallet\Domain\User;
use PDOException;
use PHPUnit\Framework\TestCase;

class UserRepoTest extends TestCase {


    private UserRepository $userRepo;

    public function setUp() : void {
        $this->userRepo = new UserRepository;
    }


    public function testCreateSuccess() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        var_dump($user);
        $this->assertIsObject($user);
    }

    public function testCreateFailed() : void {
        $this->expectException(PDOException::class);
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
    }


}