<?php

namespace Ewallet\Repository;

use Ewallet\Domain\User;
use Ewallet\Domain\Wallet;
use PHPUnit\Framework\TestCase;

class WalletRepoTest extends TestCase {


    private WalletRepository $walletRepo;
    private UserRepository $userRepo;

    public function setUp() :void {
        $this->userRepo = new UserRepository;
        $this->walletRepo = new WalletRepository;
        $this->walletRepo->deleteAll();
        $this->userRepo->deleteAll();
    }


    public function testCreateSuccess() : void {

        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        var_dump($user);

        $wallet = $this->walletRepo->create(new Wallet(null, $user->id, 0, "123456"));
        var_dump($wallet);

        $this->assertIsObject($user);
        $this->assertIsObject($wallet);

    }

    public function testfindByUserId() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $this->walletRepo->create(new Wallet(null, $user->id, 0, 123456));
        $wallet = $this->walletRepo->findByUserId($user->id);
        var_dump($user);
        var_dump($wallet);

        $this->assertIsObject($user);
        $this->assertIsObject($wallet);
    }


}