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

    public function testFindByUsernameFound() : void {
        
        $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "aryaashari", "12345678", "arya.jpg", false, null));
        $user = $this->userRepo->findByUsername('aryaashari');
        var_dump($user);
        $this->assertIsObject($user);
    }

    public function testFindByUsernameNotFound() : void {
        
        $user = $this->userRepo->findByUsername('asdasd');
        var_dump($user);
        $this->assertNull($user);
    }


    public function testUpdateEmailVerification() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "aryaashari", "12345678", "arya.jpg", false, null));
        var_dump($user);

        $this->userRepo->updateEmailVerification($user->id);

        $user = $this->userRepo->findByEmail("aryaashari100@gmail.com");
        var_dump($user);
        $this->assertTrue($user->email_verified);
    }


}