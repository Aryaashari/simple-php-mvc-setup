<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\Auth;
use Ewallet\Helper\FlashMessage;
use Ewallet\Model\Wallet\TopupRequest;
use Ewallet\Model\Wallet\TransferRequest;
use Ewallet\Model\Wallet\UpdatePinRequest;
use Ewallet\Repository\HistoryRepository;
use Ewallet\Repository\WalletRepository;
use Ewallet\Service\WalletService;

class WalletController {

    private WalletService $walletService; 

    public function __construct() {
        $this->walletService = new WalletService(new WalletRepository, new HistoryRepository);
    }


    public function changePinView() : void {
        View::render('/../view/wallet/change-pin.php');
    }

    public function changePin() : void {
        try {

            $oldPin = htmlspecialchars($_POST["oldPin"]);
            $newPin = htmlspecialchars($_POST["newPin"]);

            $user = Auth::User();
            $this->walletService->updatePin(new UpdatePinRequest($user, $oldPin, $newPin));

            View::redirect('/');
            FlashMessage::Send('success', 'Change PIN number successfully');
        } catch(ValidationException $e) {
            View::redirect('/users/wallet/pin/change');
            FlashMessage::Send('error', $e->getMessage());
        } catch(\Exception $e) {
            var_dump("Error 500");
            var_dump($e);
            exit();
        }
    }

    public function topup() : void {
        

        $nominal = htmlspecialchars($_POST["nominal"]);
        $pin = htmlspecialchars($_POST["pin"]);

        try {
            $user = Auth::User();

            $this->walletService->topup(new TopupRequest($user, $nominal, $pin));

            View::redirect('/');
            FlashMessage::Send('success',  'Topup successfully');
        } catch(ValidationException $e) {
            View::redirect('/');
            FlashMessage::Send('error', $e->getMessage());
        } catch(\Exception $e) {
            var_dump("Error 500");
            var_dump($e);
            exit();
        }

    }   


    public function transfer() : void {

        $accountNumber = htmlspecialchars($_POST["accountNumber"]);
        $nominal = htmlspecialchars($_POST["nominal"]);
        $pin = htmlspecialchars($_POST["pin"]);
        // var_dump($accountNumber);
        // var_dump($pin);
        // var_dump($nominal);
        // exit();
        try {

            $user = Auth::User();
            $this->walletService->transfer(new TransferRequest($user, $accountNumber, $pin, $nominal));

            View::redirect('/');
            FlashMessage::Send('success',  'Transfer successfully');
        } catch(ValidationException $e) {
            // var_dump($e->getMessage());
            // exit();
            FlashMessage::Send('error', $e->getMessage());
            View::redirect('/');
        } catch(\Exception $e) {
            var_dump("Error 500");
            var_dump($e);
            exit();
        }
    }


}