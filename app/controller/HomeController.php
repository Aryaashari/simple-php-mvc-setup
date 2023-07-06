<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Helper\Auth;
use Ewallet\Repository\HistoryRepository;
use Ewallet\Repository\WalletRepository;
use Ewallet\Service\HistoryService;
use Ewallet\Service\WalletService;

class HomeController {

    private WalletService $walletService; 
    private HistoryService $historyService; 

    public function __construct() {
        $this->walletService = new WalletService(new WalletRepository, new HistoryRepository);
        $this->historyService = new HistoryService(new HistoryRepository);
    }

    public function index() {
        $user = Auth::User();
        $wallet = $this->walletService->getDataByUsername($user->username);
        $histories = $this->historyService->getByAccountNumber($wallet->account_number);
        $data = [
            "username" => $user->username,
            "fullname" => $user->name,
            "email" => $user->email,
            "photo" => $user->profile_photo,
            "accountNumber" => $wallet->account_number,
            "balance" => $wallet->balance,
            "histories" => $histories
        ];

        View::render("home.php",$data);
    }

}