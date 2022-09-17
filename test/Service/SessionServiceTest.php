<?php

namespace Ewallet\Service;

use Ewallet\Domain\User;
use Ewallet\Model\Session\CreateSessionRequest;
use Ewallet\Repository\SessionRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Service\SessionService;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase {


    private SessionService $sessionService;
    private SessionRepository $sessionRepo;
    private UserRepository $userRepo;

    public function setUp() : void {
        $this->userRepo = new UserRepository;
        $this->sessionRepo = new SessionRepository;
        $this->sessionService = new SessionService($this->sessionRepo, $this->userRepo); 
        $this->sessionRepo->deleteAll();
        $this->userRepo->deleteAll();
    }

    public function testCreateSession() {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "profile.jpg", false, null));
        $session = $this->sessionService->createSession(new CreateSessionRequest($user->id, "192.168.100.12", "Chrome"));
        var_dump($session);
        $this->assertIsObject($session);
    }

    public function testUpdateLastActivatedTime() {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "profile.jpg", false, null));
        $session = $this->sessionService->createSession(new CreateSessionRequest($user->id, "192.168.100.12", "Chrome"));
        $session = $this->sessionRepo->findById($session->id);
        var_dump($session);

        $this->sessionService->updateLastActivatedTime($session->id);
        $session = $this->sessionRepo->findById($session->id);
        var_dump($session);
        $this->assertIsObject($session);
    }

    public function testDeleteSession() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "profile.jpg", false, null));
        $session = $this->sessionService->createSession(new CreateSessionRequest($user->id, "192.168.100.12", "Chrome"));
        $session = $this->sessionRepo->findById($session->id);
        var_dump($session);
        $this->assertIsObject($session);

        $this->sessionService->deleteSession($session->id);
        $session = $this->sessionRepo->findById($session->id);
        var_dump($session);
        $this->assertNull($session);
    }


}