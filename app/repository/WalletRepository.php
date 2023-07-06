<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;
use Ewallet\Domain\Wallet;

class WalletRepository {


    private \PDO $db;


    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByUsername(string $username) : Wallet | null {
        try {

            $stmt = $this->db->prepare('SELECT * FROM wallets WHERE username=?');
            $stmt->execute([$username]);
            
            if ($wallet = $stmt->fetch()) {
                return new Wallet($wallet["account_number"], $wallet["username"], $wallet["balance"], $wallet["pin"], $wallet["create_time"], $wallet["update_time"]);
            }
    
            return null;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function findByAccountNumber(int $account_number) : Wallet | null {
        try {

            $stmt = $this->db->prepare('SELECT * FROM wallets WHERE account_number=?');
            $stmt->execute([$account_number]);
            
            if ($wallet = $stmt->fetch()) {
                return new Wallet($wallet["account_number"], $wallet["username"], $wallet["balance"], $wallet["pin"], $wallet["create_time"], $wallet["update_time"]);
            }
    
            return null;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function create(Wallet $wallet) : Wallet {

        try {

            $dateNow = date('Y-m-d H:i:s', time());
            $wallet->create_time = $dateNow;
            $wallet->update_time = $dateNow;
            $account_number = rand(1,9999999999);
            $stmt = $this->db->prepare('INSERT INTO wallets(account_number, username, balance, pin, create_time, update_time) VALUES(?,?,?,?,?,?)');
            $stmt->execute([$account_number, $wallet->username, $wallet->balance, $wallet->pin, $wallet->create_time, $wallet->update_time]);

            $wallet->account_number = $account_number;
            return $wallet;

        } catch(\Exception $e) {
            throw $e;
        }

    }

    public function update(Wallet $wallet) : Wallet {
        try {

            $dateNow = date('Y-m-d H:i:s', time());
            $stmt = $this->db->prepare('UPDATE wallets SET account_number=?, username=?, balance=?, pin=?, create_time=?, update_time=? WHERE account_number=?');
            $stmt->execute([$wallet->account_number, $wallet->username, $wallet->balance, $wallet->pin, $wallet->create_time, $dateNow, $wallet->account_number]);

            $wallet->update_time = $dateNow;

            return $wallet;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function deleteAll() : void {
        try {
            $this->db->query("DELETE FROM wallets");
            return;
        } catch(\Exception $e) {
            throw $e;
        }
    }


}