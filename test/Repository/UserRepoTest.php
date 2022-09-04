<?php

namespace Ewallet\Repository;

use Ewallet\Domain\User;
use PDOException;
use PHPUnit\Framework\TestCase;

class UserRepoTest extends TestCase {


    private UserRepository $userRepo;

    public function setUp() : void {
        $this->userRepo = new UserRepository;
        $this->userRepo->deleteAll();
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

    public function testFindByEmailFound() : void {
        
        $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $user = $this->userRepo->findByEmail('aryaashari100@gmail.com');
        var_dump($user);
        $this->assertIsObject($user);
    }

    public function testFindByEmailNotFound() : void {
        
        $user = $this->userRepo->findByEmail('aryaashari100@gmail.com');
        var_dump($user);
        $this->assertNull($user);
    }


}