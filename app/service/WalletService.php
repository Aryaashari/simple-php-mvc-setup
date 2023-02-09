<?php

namespace Ewallet\Service;

use Ewallet\Repository\WalletRepository;
use Ewallet\Domain\Wallet;
use Exception;

class WalletService {

    private WalletRepository $walletRepo;

    function __construct(WalletRepository $walletRepo)
    {
        $this->walletRepo = $walletRepo;    
    }


    function getDataByUserId(int $userId) : Wallet | null {
        try {

            $wallet = $this->walletRepo->findByUserId($userId);
            return $wallet;


        } catch(Exception $e) {
            throw $e;
        }
    }



}