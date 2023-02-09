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

    public function findByUserId(int $userId) : Wallet | null {
        try {

            $stmt = $this->db->prepare('SELECT * FROM wallets WHERE user_id=?');
            $stmt->execute([$userId]);
            
            if ($wallet = $stmt->fetch()) {
                return new Wallet($wallet["id"], $wallet["user_id"], $wallet["balance"], $wallet["pin"], $wallet["create_time"], $wallet["update_time"]);
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
            $id = rand(1,9999999999);
            $stmt = $this->db->prepare('INSERT INTO wallets(id, user_id, balance, pin, create_time, update_time) VALUES(?,?,?,?,?,?)');
            $stmt->execute([$id, $wallet->user_id, $wallet->balance, $wallet->pin, $wallet->create_time, $wallet->update_time]);

            $wallet->id = $id;
            return $wallet;

        } catch(\Exception $e) {
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