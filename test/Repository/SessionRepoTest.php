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

        $session = $this->sessionRepo->create($user->id, "192.168.0.1", "chrome::arya-ashari");
        var_dump($session);
        $this->assertIsObject($user);
        $this->assertIsObject($session);
    }

    public function testFindById() {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", null,true,date("Y-m-d H:i:s", time())));

        $session1 = $this->sessionRepo->create($user->id, "192.168.0.1", "chrome::arya-ashari");

        $session = $this->sessionRepo->findById($session1->id);

        $this->assertSame($session1->id, $session->id);
        $this->assertSame($session1->user_id, $session->user_id);
        $this->assertSame($session1->ip_address, $session->ip_address);
        $this->assertSame($session1->user_agent, $session->user_agent);
        $this->assertSame($session1->last_activated_time, $session->last_activated_time);
        $this->assertSame($session1->expire_time, $session->expire_time);
        $this->assertSame($session1->create_time, $session->create_time);
    }

    public function testUpdate() { 
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", null,true,date("Y-m-d H:i:s", time())));

        $session1 = $this->sessionRepo->create($user->id, "192.168.0.1", "chrome::arya-ashari");

        $session1->user_agent = "chrome::dul-fitrah";
        $session1->last_activated_time = time();
        $session1->expire_time = time() + 300;
        $session2 = $this->sessionRepo->update($session1);

        var_dump($session2);

        $this->assertSame($session1->id, $session2->id);
        $this->assertSame($session1->user_id, $session2->user_id);
        $this->assertSame($session1->ip_address, $session2->ip_address);
        $this->assertSame($session1->user_agent, $session2->user_agent);
        $this->assertSame($session1->last_activated_time, $session2->last_activated_time);
        $this->assertSame($session1->expire_time, $session2->expire_time);
        $this->assertSame($session1->create_time, $session2->create_time);
    }

    public function testDelete() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", null,true,date("Y-m-d H:i:s", time())));

        $session1 = $this->sessionRepo->create($user->id, "192.168.0.1", "chrome::arya-ashari");

        $this->sessionRepo->delete($session1->id);

        $session = $this->sessionRepo->findById($session1->id);

        $this->assertNull($session);
    }

}