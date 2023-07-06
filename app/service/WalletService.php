<?php

namespace Ewallet\Service;

use Ewallet\Config\Database;
use Ewallet\Domain\History;
use Ewallet\Exception\ValidationException;
use Ewallet\Repository\WalletRepository;
use Ewallet\Domain\Wallet;
use Ewallet\Model\Wallet\TopupRequest;
use Ewallet\Model\Wallet\TransferRequest;
use Ewallet\Model\Wallet\UpdatePinRequest;
use Ewallet\Repository\HistoryRepository;
use Exception;

class WalletService {

    private WalletRepository $walletRepo;
    private HistoryRepository $historyRepo;

    function __construct(WalletRepository $walletRepo, HistoryRepository $historyRepo)
    {
        $this->walletRepo = $walletRepo;    
        $this->historyRepo = $historyRepo;
    }


    function getDataByUsername(string $username) : Wallet | null {
        try {

            $wallet = $this->walletRepo->findByUsername($username);
            return $wallet;


        } catch(Exception $e) {
            throw $e;
        }
    }

    function getDataByAccountNumber(int $accountNumber) : Wallet | null {
        try {

            $wallet = $this->walletRepo->findByAccountNumber($accountNumber);
            return $wallet;


        } catch(Exception $e) {
            throw $e;
        }
    }


    public function updatePin(UpdatePinRequest $request) : void {
        try {

            $wallet = $this->getDataByUsername($request->user->username);

            if($request->oldPin == "") {
                throw new ValidationException("PIN Number is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->oldPin)) {
                throw new ValidationException("PIN Number must be integer!");
            } else if(strlen($request->oldPin) != 6) {
                throw new ValidationException("PIN Number must be 6 characters!");
            } else if($wallet->pin != $request->oldPin) {
                throw new ValidationException("PIN Number invalid!");
            }

            if($request->newPin == "") {
                throw new ValidationException("PIN Number is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->newPin)) {
                throw new ValidationException("PIN Number must be integer!");
            } else if(strlen($request->newPin) != 6) {
                throw new ValidationException("PIN Number must be 6 characters!");
            }

            $wallet->pin = $request->newPin;
            $this->walletRepo->update($wallet);

        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function topup(TopupRequest $request) : void {
        try {
            
            Database::startTransaction();
            $wallet = $this->getDataByUsername($request->user->username);

            // validasi request

            if ($request->nominal == "") {
                throw new ValidationException("Nominal is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->nominal)) {
                throw new ValidationException("Nominal must be integer!");
            } else if ($request->nominal < 10000 || $request->nominal > 1000000) {
                throw new ValidationException("Min Topup Rp. 10000 & Max Topup Rp. 1000000");
            }

            if($request->pin == "") {
                throw new ValidationException("PIN Number is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->pin)) {
                throw new ValidationException("PIN Number must be integer!");
            } else if(strlen($request->pin) != 6) {
                throw new ValidationException("PIN Number must be 6 characters!");
            } else if($wallet->pin != $request->pin) {
                throw new ValidationException("PIN Number invalid!");
            }

            

            $wallet->balance += $request->nominal;

            $this->walletRepo->update($wallet);

            // add history
            $history = new History(null, $wallet->account_number, null, $request->nominal, "Top Up Rp.".$request->nominal, "in", 'topup', null);

            $this->historyRepo->create($history);

            Database::commitTransaction();


        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }


    public function transfer(TransferRequest $request) : void {

        try {

            Database::startTransaction();

            $originWallet = $this->getDataByUsername($request->user->username);

            // validasi request
            if ($request->dest_account == "") {
                throw new ValidationException("Destination account is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->dest_account)) {
                throw new ValidationException("Destination account must be integer!");
            } else if ($request->dest_account == $originWallet->account_number) {
                throw new ValidationException("Origin account must be different with destination account!");
            }

            $destWallet = $this->getDataByAccountNumber($request->dest_account);
            if ($destWallet == null) {
                throw new ValidationException("Destination account not found!");
            }
            
            if ($request->nominal == "") {
                throw new ValidationException("Nominal is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->nominal)) {
                throw new ValidationException("Nominal must be integer!");
            } else if ($request->nominal < 10000 || $request->nominal > 5000000) {
                throw new ValidationException("Min Topup Rp. 10000 & Max Topup Rp. 5000000");
            } else if ($request->nominal > $originWallet->balance) {
                throw new ValidationException("Balance is insufficient!");
            }

            if($request->pin == "") {
                throw new ValidationException("PIN Number is required!");
            } else if (!preg_match_all('/^[0-9]*$/',$request->pin)) {
                throw new ValidationException("PIN Number must be integer!");
            } else if(strlen($request->pin) != 6) {
                throw new ValidationException("PIN Number must be 6 characters!");
            } else if($originWallet->pin != $request->pin) {
                throw new ValidationException("PIN Number invalid!");
            }

            
            // mengurangi balance origin account
            $originWallet->balance -= $request->nominal;
            $this->walletRepo->update($originWallet);

            // menambah balance origin account
            $destWallet->balance += $request->nominal;
            $this->walletRepo->update($destWallet);

            // mencatat history origin account
            $this->historyRepo->create(new History(null, $originWallet->account_number, $destWallet->account_number, $request->nominal, "Transfer Rp.".$request->nominal, "out", "transfer", null));
            
            // mencatat history destination account
            $this->historyRepo->create(new History(null, $destWallet->account_number, $originWallet->account_number, $request->nominal, "Transfer Rp.".$request->nominal, "in", "transfer", null));

            Database::commitTransaction();
        } catch (Exception $e) {
            Database::rollbackTransaction();
            throw $e;
         }

    }



}