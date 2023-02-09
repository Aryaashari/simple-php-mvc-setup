<?php

namespace Ewallet\Service;

use Ewallet\Domain\Wallet;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use PHPUnit\Framework\Assert;
use Ewallet\Domain\User;
use PHPUnit\Framework\TestCase;

class WalletServiceTest extends TestCase {


    private WalletRepository $walletRepo;
    private UserRepository $userRepo;
    private WalletService $walletService;


    public function setUp():void {
        $this->userRepo = new UserRepository;
        $this->walletRepo = new WalletRepository;
        $this->walletService = new WalletService($this->walletRepo);
        $this->walletRepo->deleteAll();
        $this->userRepo->deleteAll();
    }


    public function testGetDataByUserId() : void {
        $user = $this->userRepo->create(new User(null, "Arya", "aryaashari100@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $this->walletRepo->create(new Wallet(null, $user->id, 0, 123456));

        $wallet = $this->walletService->getDataByUserId($user->id);
        var_dump($wallet);
        Assert::assertIsObject($wallet);
    }

}