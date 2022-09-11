<?php

namespace Ewallet\Repository;

use Ewallet\Domain\Session;
use Ewallet\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepoTest extends TestCase {

    private UserRepository $userRepo;
    private SessionRepository $sessionRepo;

    public function setUp() : void {
        $this->userRepo = new UserRepository;
        $this->sessionRepo = new SessionRepository;
        $this->sessionRepo->deleteAll();
        $this->userRepo->deleteAll();
    }

    public function testCreate() {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", null,true,date("Y-m-d H:i:s", time())));
        var_dump($user);
        // // $ipAddress = $_SERVER["REMOTE_ADDR"];
        // var_dump($ipAddress);
        $id = time();
        var_dump($id);
        // $session = $this->sessionRepo->create($user->id, "192.168.0.1", "chrome::arya-ashari");
        // var_dump($session);
        $this->assertIsObject($user);
        // $this->assertIsObject($session);
    }

}